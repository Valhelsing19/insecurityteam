const { translate } = require('@vitalets/google-translate-api');
const franc = require('franc');

// Waray-Waray keywords for categories
const warayKeywords = {
  'broken-streetlights': [
    // English keywords
    'streetlight', 'street light', 'streetlight', 'street lamp', 'streetlamp', 'street lamp', 
    'light post', 'lightpost', 'lamp post', 'lamppost', 'pole light', 'outdoor light', 
    'outdoor lighting', 'public light', 'public lighting', 'road light', 'road lighting',
    'broken light', 'broken lamp', 'broken streetlight', 'broken street light', 'broken lamp post',
    'flickering light', 'flickering streetlight', 'dark street', 'no light', 'light out',
    'light broken', 'lamp broken', 'streetlight broken', 'street light broken', 'poste broken',
    'light not working', 'lamp not working', 'streetlight not working', 'dead light', 'dead lamp',
    // Waray keywords
    'suga', 'suga ha karsada', 'suga ha dalan', 'poste', 'poste hit suga', 'guba nga suga',
    'guba nga poste', 'guba nga ilaw', 'wara suga', 'wara ilaw', 'nasira nga suga',
    'nasira nga poste', 'nasira nga ilaw', 'kuryente ha poste', 'kuryente ha suga',
    'guba nga kuryente hit suga', 'guba nga kuryente ha poste'
  ],
  'potholes': [
    // English keywords
    'pothole', 'potholes', 'pot hole', 'pot holes', 'road hole', 'road holes', 'street hole',
    'street holes', 'road damage', 'street damage', 'road crack', 'street crack', 'road crack',
    'pavement hole', 'pavement holes', 'asphalt hole', 'asphalt holes', 'road depression',
    'road depressions', 'street depression', 'street depressions', 'road bump', 'road bumps',
    'uneven road', 'uneven street', 'road surface', 'damaged road', 'damaged street',
    'broken road', 'broken street', 'road repair', 'street repair', 'road hazard',
    'street hazard', 'dangerous road', 'dangerous street', 'road defect', 'street defect',
    // Waray keywords
    'lubak', 'lubak ha karsada', 'lubak ha dalan', 'guba nga karsada', 'guba nga dalan',
    'nasira nga karsada', 'nasira nga dalan', 'butas ha karsada', 'butas ha dalan',
    'hukag ha karsada', 'hukag ha dalan', 'guba nga agian', 'nasira nga agian'
  ],
  'clogged-drainage': [
    // English keywords
    'drainage', 'drain', 'drains', 'drainage system', 'drainage pipe', 'drainage pipes',
    'clogged drain', 'clogged drains', 'blocked drain', 'blocked drains', 'blocked drainage',
    'clogged drainage', 'drainage blocked', 'drainage clogged', 'sewer', 'sewer drain',
    'sewer blocked', 'sewer clogged', 'storm drain', 'storm drains', 'storm drainage',
    'gutter', 'gutters', 'gutter blocked', 'gutter clogged', 'water drain', 'water drainage',
    'flooding', 'flood', 'water not draining', 'water accumulation', 'standing water',
    'water pooling', 'drainage problem', 'drainage issue', 'drain problem', 'drain issue',
    'sewer problem', 'sewer issue', 'backed up drain', 'backed up drainage',
    // Waray keywords
    'tubig', 'tubig ha karsada', 'tubig ha dalan', 'baha', 'baha ha karsada', 'baha ha dalan',
    'tubo', 'tubo hit tubig', 'guba nga tubo', 'nasira nga tubo', 'barado nga tubo',
    'barado nga drain', 'clogged nga tubo', 'blocked nga tubo', 'wara nag-agas nga tubig',
    'nagbubuga nga tubig', 'nag-accumulate nga tubig', 'standing nga tubig'
  ],
  'damaged-sidewalks': [
    // English keywords
    'sidewalk', 'sidewalks', 'walkway', 'walkways', 'footpath', 'footpaths', 'pavement',
    'pavements', 'walking path', 'walking paths', 'pedestrian path', 'pedestrian paths',
    'sidewalk damage', 'sidewalk broken', 'sidewalk cracked', 'sidewalk uneven', 'sidewalk hazard',
    'broken sidewalk', 'broken walkway', 'cracked sidewalk', 'cracked walkway', 'uneven sidewalk',
    'uneven walkway', 'damaged sidewalk', 'damaged walkway', 'sidewalk repair', 'walkway repair',
    'sidewalk defect', 'walkway defect', 'sidewalk trip hazard', 'walkway trip hazard',
    'sidewalk safety', 'walkway safety', 'sidewalk maintenance', 'walkway maintenance',
    // Waray keywords
    'agian', 'agian ha tawo', 'agian ha pedestrian', 'guba nga agian', 'nasira nga agian',
    'guba nga sidewalk', 'nasira nga sidewalk', 'guba nga walkway', 'nasira nga walkway',
    'cracked nga agian', 'uneven nga agian', 'hazard nga agian', 'dangerous nga agian'
  ],
  other: []
};

// Priority keywords (high priority)
const highPriorityKeywords = {
  en: ['urgent', 'emergency', 'dangerous', 'broken', 'critical', 'immediate', 'hazard', 'unsafe', 'flooding', 'fire', 'flood', 'leaking', 'spark', 'smoke', 'electrocution', 'danger'],
  war: ['dali', 'emergency', 'delikado', 'nasira', 'kritikal', 'immediate', 'peligro', 'unsafe', 'baha', 'kalayo', 'nagbubuga', 'nagkakuryente', 'usok', 'peligroso']
};

// Category detection function
function detectCategory(text) {
  const lowerText = text.toLowerCase();
  let maxScore = 0;
  let detectedCategory = 'other';

  for (const [category, keywords] of Object.entries(warayKeywords)) {
    if (category === 'other') continue;
    
    let score = 0;
    keywords.forEach(keyword => {
      const regex = new RegExp(`\\b${keyword.toLowerCase()}\\b`, 'i');
      if (regex.test(lowerText)) {
        score += 1;
      }
    });
    if (score > maxScore) {
      maxScore = score;
      detectedCategory = category;
    }
  }

  return detectedCategory;
}

// Priority detection function
function detectPriority(text, language) {
  const lowerText = text.toLowerCase();
  const keywords = highPriorityKeywords[language] || highPriorityKeywords.en;
  
  for (const keyword of keywords) {
    const regex = new RegExp(`\\b${keyword.toLowerCase()}\\b`, 'i');
    if (regex.test(lowerText)) {
      return 'high';
    }
  }

  // Check for urgency indicators
  if (lowerText.includes('!') || lowerText.match(/\b(now|immediately|asap|urgent|dali|emergency)\b/i)) {
    return 'high';
  }

  // Check for exclamation marks (urgency indicator)
  const exclamationCount = (lowerText.match(/!/g) || []).length;
  if (exclamationCount >= 2) {
    return 'high';
  }

  return 'medium';
}

exports.handler = async (event, context) => {
  // Handle CORS
  if (event.httpMethod === 'OPTIONS') {
    return {
      statusCode: 200,
      headers: {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': 'Content-Type',
        'Access-Control-Allow-Methods': 'POST, OPTIONS'
      },
      body: ''
    };
  }

  if (event.httpMethod !== 'POST') {
    return {
      statusCode: 405,
      headers: { 
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ error: 'Method not allowed' })
    };
  }

  try {
    const { description, title } = JSON.parse(event.body || '{}');
    
    if (!description && !title) {
      return {
        statusCode: 400,
        headers: { 
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Description or title is required' })
      };
    }

    const combinedText = `${title || ''} ${description || ''}`.trim();

    if (combinedText.length < 3) {
      return {
        statusCode: 400,
        headers: { 
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*'
        },
        body: JSON.stringify({ error: 'Text too short for analysis' })
      };
    }

    // Step 1: Detect language
    const detectedLang = franc(combinedText);
    const isWaray = detectedLang === 'war' || detectedLang.startsWith('war');
    const isEnglish = detectedLang === 'eng' || detectedLang.startsWith('eng');

    // Step 2: Translate if needed
    let translatedText = combinedText;
    let translationUsed = false;
    
    if (isWaray && !isEnglish) {
      try {
        const result = await translate(combinedText, { to: 'en' });
        translatedText = result.text;
        translationUsed = true;
      } catch (translateError) {
        console.error('Translation error:', translateError);
        // Continue with original text if translation fails
        translatedText = combinedText;
      }
    }

    // Step 3: Detect category (use translated text for better accuracy)
    const category = detectCategory(translatedText);

    // Step 4: Detect priority (use original language for better context)
    const priority = detectPriority(combinedText, isWaray ? 'war' : 'en');

    return {
      statusCode: 200,
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({
        success: true,
        category,
        priority,
        detectedLanguage: detectedLang,
        translatedText: translationUsed ? translatedText : null,
        confidence: {
          category: category !== 'other' ? 'high' : 'medium',
          priority: priority === 'high' ? 'high' : 'medium'
        }
      })
    };
  } catch (error) {
    console.error('Analysis error:', error);
    return {
      statusCode: 500,
      headers: { 
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*'
      },
      body: JSON.stringify({ 
        error: 'Analysis failed',
        message: error.message 
      })
    };
  }
};


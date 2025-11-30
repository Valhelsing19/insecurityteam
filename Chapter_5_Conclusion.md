CHAPTER 5: Conclusion and Recommendations

5.1 Conclusions

The development of the Smart Neighborhood Maintenance Request and Response System using Automated Classification was conceptualized against the backdrop of long-standing inefficiencies and fragmentation in maintenance reporting within local communities. The conventional ways of reporting neighborhood issues, such as manual filing, calling, or in-person visits, have traditionally caused delays in response, poor coordination, and lack of transparency between residents and local authorities. Based on this premise, this study designed a digital solution by incorporating automated text classification and modern web technology to bolster communication, automate maintenance processes, and enhance public participation in community development.

The designed system integrates rule-based text classification to automatically categorize and prioritize maintenance requests, thereby enabling administrative personnel to manage reports from residents more efficiently. Residents can report issues with streetlights, potholes, drainage problems, and damaged sidewalks through a responsive web platform accessible on both desktop and mobile browsers, while local government officials can track, classify, and update these reports using an administrative dashboard. The system employs a modern serverless architecture with Netlify Functions for backend services and Supabase PostgreSQL database for data persistence, providing scalability and cost-effectiveness. By automating request categorization and prioritization through keyword matching, the system minimizes manual workload, reduces human errors, and improves decision-making with data-driven insights. Real-time tracking and email notifications within the system assure full transparency: residents are informed about the status of their reported requests through email updates and can monitor progress through the web interface.

The system implements multiple authentication methods, including traditional email/password registration and Google Sign-In OAuth integration for residents, while officials use separate username/password authentication through a dedicated officials management system. JWT (JSON Web Token) authentication ensures secure, stateless user sessions suitable for serverless architecture. Role-based access control distinguishes between resident users and administrative officials, ensuring appropriate system access and functionality. The system includes comprehensive activity logging that tracks all official actions including status changes, priority updates, and request assignments, providing complete accountability and audit trails.

The study underscores that technological advancement is not confined to global or large-scale smart city projects. On the contrary, automated classification and web-based technologies in the local spheres of barangays or municipalities can bring meaningful changes to public service management. By empowering residents to actively contribute to community issue reporting and monitoring, the system fosters accountability, collaboration, and reinforces trust between citizens and their local leadership. It has also shown that innovation and modernization can be achieved with scalable and practical solutions that are fitting for local contexts, utilizing modern serverless architecture to reduce infrastructure costs while maintaining high availability.

While the prototype realized its set development objectives, limitations were also evident. In respect of classification, the rule-based keyword matching system relies on predefined keyword lists that may not capture all variations of issue descriptions, potentially leading to misclassification in some cases. The system currently only processes text descriptions and does not analyze uploaded images for classification. The system is web-based and not supported by a dedicated mobile application, which could restrict access for some users who prefer native mobile apps. Notifications are currently limited to email, while pilot testing is restricted to a small area. The serverless architecture, while providing scalability benefits, requires careful management of Netlify Functions and Supabase database configuration. Despite these constraints, the project offers a solid foundation for further development and research, as these identified limitations point out aspects where continuous improvement could take place.

In summary, the Smart Neighborhood Maintenance Request and Response System epitomizes what is possible at the community level by integrating automated classification and modern web technology into infrastructure management. It furthers efficiency, responsiveness, and transparency in local governance and engages residents as active participants in neighborhood upkeep. The successful implementation of a serverless architecture demonstrates that advanced technology can be accessible to local government units without requiring extensive infrastructure investment. The separate officials management system with comprehensive activity logging provides accountability and transparency that was lacking in traditional manual systems. As such, this research contributes to the nascent field of smart city and automated public service innovations while opening up opportunities for inclusive, data-driven, and sustainable means of pursuing local governance. Success with the prototype represents a milestone in the effort to create smarter, safer, and more connected communities for the future.

5.2 Recommendations

1. Enhance Classification System with Machine Learning

The existing rule-based keyword matching system provides a solid foundation, but we recommend implementing machine learning-based classification using TensorFlow/Keras or similar frameworks to improve accuracy and handle edge cases. Collecting more text samples and photos about real community problems – such as potholes, broken streetlights, drainage issues, and sidewalk damages – would enable training supervised learning models. As the dataset increases, machine learning models will be able to categorize and prioritize maintenance requests more accurately, especially for descriptions that don't match predefined keywords. Additionally, implementing image classification using computer vision would enable automatic analysis of uploaded photos, further enhancing classification accuracy. Implementing continuous learning mechanisms where the model improves based on administrative corrections would further enhance accuracy over time.

2. Develop a Native Mobile Application Version

Since the prototype is solely web-based, it is suggested to develop native mobile applications (Android and iOS) to ensure that all citizens can access the service conveniently, particularly those who primarily use their smartphones. A mobile app would also enable better utilization of device features such as GPS for automatic location tagging, camera integration for easier photo capture, and push notifications for real-time updates. The mobile app could utilize the existing Netlify Functions API, ensuring consistency with the web platform while providing an enhanced mobile user experience.

3. Expand Notification Channels (SMS and Push Notifications)

The current system is only capable of email-based notifications. It is recommended to add SMS alerts and push notifications (for mobile apps) to facilitate better communication between the system, community members, and government officers. This way, users get immediate updates when they are not always in the habit of checking their email. Integration with SMS gateway services (such as Twilio or local telecommunications APIs) and push notification services would significantly improve user engagement and response times.

4. Extend Supported Maintenance Problem Categories

The prototype currently concentrates on certain local infrastructure issues (streetlights, potholes, drainage, sidewalks). Additional public infrastructure issues should be added to the categories, such as waste disposal problems, road obstructions, environmental contamination, damaged public facilities, and safety hazards. This expansion would ensure that the system becomes more comprehensive and useful for a wider range of community maintenance needs. The classification system (whether rule-based or machine learning-based) would need to be updated to accommodate these new categories.

5. Wider Pilot Testing in Multiple Barangays or Areas

As the study's pilot implementation covers a small geographic area, further pilot testing that involves more residents and different barangays is recommended. This is considered necessary to correctly assess system usability, reveal operational challenges, and gather needed feedback in refining both the classification system and the platform's user interface before full deployment. Large-scale testing would also help validate the system's performance under higher concurrent user loads and diverse usage patterns.

6. Enhance Serverless Architecture Performance

While the Netlify Functions provide scalability benefits, it is recommended to optimize function performance through caching mechanisms, database connection pooling, and response time optimization. Implementing a Content Delivery Network (CDN) for static assets and exploring edge computing capabilities could further improve response times, especially for users in remote areas. Monitoring and analytics tools should be integrated to track function performance and identify bottlenecks.

7. Integrate with Existing Municipal Systems

To maximize the system's utility, future development should focus on integrating with existing municipal maintenance workflows, databases, and management systems. This would enable seamless data exchange, reduce duplicate data entry, and provide a unified view of maintenance operations. Integration with Geographic Information Systems (GIS) could enhance location-based analytics and mapping capabilities.

8. Implement Advanced Analytics and Reporting Features

The system should be enhanced with more sophisticated analytics capabilities, including predictive maintenance insights, trend analysis, resource allocation optimization, and performance metrics dashboards. These features would enable local authorities to make more informed decisions about maintenance priorities, budget allocation, and long-term infrastructure planning. Machine learning models could be developed to predict maintenance needs based on historical data and patterns, representing a natural evolution from the current rule-based classification system.

9. Strengthen Security and Data Privacy Measures

While the current system implements JWT authentication and role-based access control, additional security enhancements are recommended, including two-factor authentication (2FA) for administrative accounts, enhanced encryption for sensitive data, regular security audits, and compliance verification with data privacy regulations. Regular penetration testing and vulnerability assessments would ensure the system remains secure as it scales.

10. Develop Comprehensive Documentation and Training Materials

To ensure successful adoption and long-term sustainability, comprehensive user manuals, administrator guides, and training materials should be developed. Training programs for both residents and administrative staff would facilitate smooth system adoption and maximize utilization of system features. Technical documentation for system administrators and developers would support maintenance and future enhancements.





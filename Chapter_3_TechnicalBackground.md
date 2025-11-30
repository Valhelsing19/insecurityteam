CHAPTER 3

Technical Background

3.1 Current System

Currently, the process of reporting and addressing neighborhood maintenance issues is predominantly manual and fragmented. Residents typically report problems such as broken streetlights, potholes, and clogged drainage either through phone calls, written forms, or in-person visits to local government offices. This manual system often leads to delays due to the lack of centralized reporting channels and poor tracking mechanisms. Requests are logged inconsistently, prioritization is performed manually, and communication between the residents and maintenance staff is limited. These inefficiencies result in delayed repairs, reduced transparency, and overall dissatisfaction with public infrastructure management. Moreover, there is no automated system to analyze, categorize, or prioritize requests based on urgency, which further slows down the maintenance workflow.

3.2 Proposed System

The proposed Smart Neighborhood Maintenance Request and Response System addresses the limitations of the current manual process by utilizing automated text classification and a web-based platform to streamline maintenance reporting and response. Residents will be empowered to submit detailed maintenance requests including photos and location information via a responsive web interface. Local government officials will use an integrated administrative dashboard that leverages rule-based keyword matching to automatically categorize and prioritize requests, facilitating faster and data-driven decision-making. Real-time tracking, email notifications, and analytics will enhance transparency and communication between residents and officials. This integration of modern technologies will greatly improve maintenance efficiency, resource allocation, and community engagement. To implement this proposed solution, the following software, hardware, and people-ware components are required.

3.2.1 Software

1. Netlify Functions
   - Features Used: Node.js runtime for serverless functions
   - Purpose: Serverless backend API endpoints for authentication, user registration, maintenance request management, official account management, and activity logging. Enables scalable, cloud-based backend services without managing server infrastructure. This is the primary backend for production deployment.

2. Bootstrap 5.3.8
   - Features Used: Responsive CSS framework
   - Purpose: Frontend user interface design for responsive and mobile-friendly web pages. Enables rapid UI styling and layout customization. Used alongside Tailwind CSS for comprehensive styling.

3. Tailwind CSS 4.0
   - Features Used: Utility-first CSS framework
   - Purpose: Additional styling framework for modern, customizable UI components and responsive design elements. Works in conjunction with Bootstrap to provide flexible and efficient styling solutions.

4. VSCode
   - Features Used: Code editor with extensions
   - Purpose: Primary integrated development environment (IDE) for coding, debugging, and Git version control integrations.

5. Supabase
   - Features Used: PostgreSQL database with REST API
   - Purpose: Cloud-hosted PostgreSQL database providing data persistence, authentication capabilities, and real-time features. Serves as the production database for storing user data, maintenance requests, officials, and activity logs.

6. PostgreSQL
   - Features Used: Relational database system
   - Purpose: The underlying database engine powering Supabase. Stores user submissions, administrative data, request statuses, official accounts, activity logs, and system logs persistently with ACID compliance and robust data integrity.

7. Node.js
   - Features Used: JavaScript runtime
   - Purpose: Runtime environment for Netlify Functions, enabling serverless backend functionality and API endpoints.

8. JWT (jsonwebtoken)
   - Features Used: Token-based authentication
   - Purpose: Secure authentication mechanism using JSON Web Tokens stored in localStorage, replacing traditional session-based authentication. Provides stateless authentication suitable for serverless architectures.

9. GitHub
   - Features Used: Online repository and version control
   - Purpose: Manage source code with Git repositories, facilitate collaboration, and track version history.

10. Franc
    - Features Used: Language detection library
    - Purpose: Automatically detects the language of user-submitted text descriptions (English or Waray-Waray) to enable appropriate processing and translation.

11. Google Translate API (@vitalets/google-translate-api)
    - Features Used: Text translation service
    - Purpose: Translates Waray-Waray text descriptions to English for improved keyword matching accuracy in the rule-based classification system.

12. Google Sign-In API
    - Features Used: OAuth 2.0 authentication
    - Purpose: Third-party authentication service allowing residents to sign in using their Google accounts, enhancing user convenience and security.

The software stack utilizes a modern serverless architecture with Netlify Functions as the primary backend for production deployment. Netlify Functions (Node.js) provide scalable, cloud-based backend services without requiring traditional server management. Bootstrap and Tailwind CSS work together to ensure the user interface remains responsive and accessible across devices, with Bootstrap providing foundational components and Tailwind offering utility-first styling capabilities. Development proceeds using VSCode as the primary IDE, with source code management through GitHub supporting version control, collaborative coding, and development lifecycle management.

The frontend is built as static HTML files for optimal performance and deployment flexibility. These static files are served directly from the Netlify CDN, ensuring fast load times and global distribution. Authentication is handled through JWT tokens stored in localStorage, providing stateless authentication suitable for serverless architectures. The system uses Supabase, a cloud-hosted PostgreSQL database, which provides robust data persistence, built-in security features, and RESTful API access. Supabase eliminates the need for separate database server management while providing enterprise-grade database capabilities.

The system implements automated text classification through a rule-based keyword matching system. When residents submit maintenance requests with text descriptions, the system uses the Franc library to detect the language (English or Waray-Waray). Waray-Waray text is automatically translated to English using the Google Translate API to improve classification accuracy. The system then matches keywords from predefined lists against the text to automatically categorize requests into predefined categories (broken-streetlights, potholes, clogged-drainage, damaged-sidewalks) and assign priority levels (low, medium, high, urgent) based on urgency indicators. This rule-based approach provides fast, reliable classification without requiring machine learning model training or inference infrastructure. Photos uploaded by residents are stored for documentation purposes but are not automatically analyzed or classified in the current implementation. The system implements a separate officials management system with dedicated authentication, allowing local government officials to manage maintenance requests independently from resident accounts. Activity logging tracks all official actions including status changes, priority updates, and request assignments, providing a complete audit trail for accountability and transparency. To maintain user engagement and transparency, email notifications update residents on their request status. Google Sign-In integration provides an additional authentication method, enhancing user convenience and reducing registration friction.

3.2.2 Hardware

1. Local Development Machines (PCs/Laptops)
   - Features Used: Support Node.js, VSCode, modern web browsers
   - Purpose: Used by developers to build, test, and debug the system in a controlled local environment. Requires Node.js runtime, modern code editor, and web browser for testing.

2. Netlify Cloud Platform
   - Features Used: Serverless hosting infrastructure
   - Purpose: Hosts the deployed web application, Netlify Functions, and static assets for public access. Provides automatic scaling, CDN distribution, and global edge network for optimal performance.

3. Supabase Cloud Platform
   - Features Used: PostgreSQL database hosting
   - Purpose: Cloud-hosted PostgreSQL database service providing data persistence, automatic backups, and high availability. Eliminates the need for dedicated database server hardware while ensuring data reliability and security.

4. Resident Devices (Smartphones, PCs)
   - Features Used: Cameras, GPS, web browsers
   - Purpose: Used by residents to access the web platform for submitting maintenance reports. Modern browsers with JavaScript support required. Mobile devices utilize built-in cameras and GPS for photo uploads and location tagging.

5. Administrative Workstations
   - Features Used: Secure internet access, large displays
   - Purpose: Used by local officials to monitor and manage maintenance requests via the dashboard. Requires stable internet connection and modern web browser for optimal administrative interface experience.

Development is performed on local machines equipped with Node.js, VSCode, and modern web browsers, giving developers a fully functional environment for building and testing Netlify Functions and frontend components. Upon deployment, the system is hosted on Netlify's cloud platform, which provides serverless function execution and static asset hosting with global CDN distribution. The production database is hosted on Supabase's cloud platform, which provides managed PostgreSQL database services with automatic backups, high availability, and built-in security features. This cloud-based infrastructure eliminates the need for dedicated server hardware while ensuring scalability and reliability.

Residents submit maintenance reports through their smartphones or personal computers, relying on device capabilities like cameras for photo uploads and GPS for location tagging. Local governmental administrative staff use workstations with sufficient display and network access to efficiently oversee requests and system analytics. The serverless architecture ensures that the system can scale automatically to handle varying loads without requiring manual infrastructure management.

3.2.3 People-ware

●	Residents (End Users)

○	Submit maintenance requests with photos, detailed descriptions, and accurate location data through the web-based platform.

○	Track the progress of their requests through real-time updates and email notifications.

○	Authenticate using traditional email/password or Google Sign-In for convenient access.

●	Administrative Staff (Local Government Officials)

○	Access the official administrative dashboard using separate username/password authentication.

○	View all maintenance requests with filtering and sorting capabilities.

○	Update request statuses (pending, active, completed, cancelled) with activity logging.

○	Set request priorities (low, medium, high, urgent) to guide resource allocation.

○	Assign requests to specific officials for accountability and task management.

○	View comprehensive activity logs tracking all actions performed on requests.

○	Generate reports and view analytics to evaluate maintenance effectiveness and optimize operations.

●	System Administrators / Developers

○	Maintain and update Netlify Functions, Supabase database configuration, classification rules, and deployment environment.

○	Manage official account creation and administration through secure API endpoints.

○	Manage version control using GitHub repositories.

○	Ensure system security, data integrity, and backup procedures for continuous operations.

○	Monitor system performance, handle database migrations, and manage cloud infrastructure (Netlify and Supabase).

This user framework promotes efficient communication and workflow, ensuring that residents have a reliable platform for maintenance reporting while staff benefit from streamlined administrative tools with automated classification assistance. System administrators provide the necessary technical support to sustain and improve the system over time, managing the serverless architecture and cloud database infrastructure to ensure optimal performance and reliability.

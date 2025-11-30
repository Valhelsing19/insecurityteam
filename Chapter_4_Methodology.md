CHAPTER 4

METHODOLOGY

This chapter presents the methods, techniques, and procedures used in the design and development of the Smart Neighborhood Maintenance Request and Response System Using Automated Classification. It describes the system requirements, the chosen system development model, and the detailed design process covering both software and database structures. Moreover, this chapter includes the test, security, and maintenance plans, as well as system representations such as Gantt and PERT charts, data flow diagrams, and the entity relationship diagram.

4.1 Requirements Analysis

Performance Requirements

Requirement	Description	Rationale

Response Time	The system shall process and classify submitted maintenance requests (text-based) within 2–3 seconds.	Meets user expectations for real-time responsiveness during reporting (Gupta, 2025).

System Uptime	The hosted system should maintain at least 95% uptime during pilot testing.	Ensures reliability of access for residents and staff aligns with standard web service benchmarks.

Data Throughput	The database shall handle up to 100 concurrent maintenance requests without data loss or corruption.	Supports community-level reporting during high-activity periods (Misuraca et al., 2020).

Classification Accuracy	The rule-based classification system must achieve at least 75% accuracy in categorizing issues into predefined classes based on keyword matching.	Balances prototype feasibility with realistic expectations for keyword-based classification without machine learning.

Serverless Function Performance	Netlify Functions shall respond to API requests within 2 seconds under normal load.	Ensures responsive user experience in the serverless architecture.

Safety Requirements

Data Validation	The system must validate uploaded files to prevent malicious or corrupted data (e.g., only image formats JPG/PNG allowed, maximum file size limits).	Prevents server crashes or injection risks from invalid uploads.

Backup and Recovery	Automatic backup of the database at least once daily during pilot testing.	Ensures data restoration in case of system failure.

Error Handling	The system must handle failed classifications gracefully by defaulting to "other" category and "medium" priority, allowing manual correction by officials.	Prevents system crashes and maintains workflow continuity.

Compliance	Follow safety standards of ISO/IEC 27001 for information security management during development.	Ensures compliance with standard IT safety and reliability guidelines.

Security Requirements

Logging and Monitoring	All user activities must be logged for auditing and troubleshooting.	Supports accountability and security audits (Kabir et al., 2021).

Privacy Compliance	Data collection must comply with the Data Privacy Act of 2012 (RA 10173).	Ensures lawful handling of personal information and user consent.

User Authentication	Users (residents and officials) must authenticate through secure credentials (JWT tokens), Google Sign-In OAuth, or unique identifiers.	Multi-factor authentication options enhance security and user convenience.

Access Control	The system must enforce role-based access for residents, officials, and system developers.	Managed using JWT token claims and role-based middleware in Netlify Functions.

API Security	All API endpoints must validate JWT tokens and implement rate limiting to prevent abuse.	Protects serverless functions from unauthorized access and DDoS attacks.

4.2 Design of Software, Systems, Product, and/or Processes

Development Life Cycle (SDLC). The Iterative Model was chosen over the traditional Waterfall approach because it is highly effective for projects where initial requirements are clear (e.g., basic reporting, tracking, and assignment) but are expected to be refined based on feedback from a small user group, such as neighborhood officials and a pilot group of citizens. This model breaks the development into small, repeatable cycles (iterations), allowing the team to deliver a functional version of the system with core features quickly, gather feedback, and then use that feedback to define and implement enhanced features (e.g., advanced reporting, resource inventory integration) in subsequent, planned iterations (Boehm, 1988). This approach minimizes risk and ensures the final system is well-tailored to the specific operational needs of the neighborhood unit.

The development of the system followed several iterations, each resulting in a working, refined product:

Iteration 1 (Core Functionality): Focused on basic requirements and design of the database schema. Implementation included setting up Supabase PostgreSQL database, creating user authentication system with JWT tokens, basic Netlify Functions for user registration and login, and establishing the foundation for maintenance request submission. Testing ensured basic functionality was operational.

Iteration 2 (Resident Reporting Module): Focused on implementing the resident-facing web interface. Implementation included responsive HTML pages, maintenance request submission forms with photo upload capability, integration with Netlify Functions for API calls, and resident dashboard for viewing submitted requests. This iteration was tested for cross-browser compatibility and mobile responsiveness.

Iteration 3 (Administrative Control): Focused on adding the design for the official management system and role-based access control. Implementation included separate officials table in database, official login portal with username/password authentication, administrative dashboard for viewing and managing all requests, status update functionality, and request prioritization features. This iteration was then tested for security, access control, and administrative workflow efficiency.

Iteration 4 (Request Assignment and Activity Logging): Based on pilot user feedback, design improvements were made to include request assignment capabilities and comprehensive activity tracking. Implementation included assigning requests to specific officials, activity log table to track all official actions (status changes, priority updates, assignments), and enhanced dashboard features for both residents and officials. This iteration was tested for accountability features and audit trail functionality.

Iteration 5 (Google Sign-In & Enhanced Features): Focused on improving user convenience and authentication options. Implementation included Google OAuth authentication integration, enhanced UI/UX improvements, real-time status updates, and email notification system. This iteration was tested for authentication flow and user experience improvements.

Iteration 6 (Analytics & Reporting): Focused on adding analytics and reporting capabilities. Implementation included statistics dashboard, request filtering and sorting, activity log viewing, and data visualization features for performance monitoring. This iteration was tested for analytics accuracy and reporting functionality.

This incremental approach ensured continuous validation by end-users, delivering a high-quality product that systematically met the project's increasing complexity while maintaining flexibility to adapt to changing requirements. The following table outlines the specific plans designed to ensure the system's quality, security, and long-term viability upon deployment.

Plan Type	Actual Plan	What to Assess During Testing

Test Plan	Conduct Unit Testing for individual components (Netlify Functions), Integration Testing for API endpoints and database interactions, System Testing across web platforms, and User Acceptance Testing (UAT) with 3 neighborhood officials and 5 residents.	Functionality: Correctness of request submission, accuracy of status updates, proper role-based access control, JWT token validation, official assignment functionality, and activity logging. Performance: Request submission speed (sub-3 seconds), Netlify Function response times, and concurrent user stability. Usability: Ease of use for first-time resident users, administrative efficiency for officials, and mobile responsiveness across devices. Classification: Accuracy of rule-based keyword matching for text categorization and priority assignment.

Security Plan	Enforce strong password hashing (bcrypt), implement JWT token-based authentication with secure storage, utilize input sanitization to prevent common web vulnerabilities (XSS, SQL injection), secure all user PII with encryption (at-rest), and implement Google OAuth security best practices.	Authentication: Successful enforcement of JWT token validation, Google Sign-In flow, and password policy. Vulnerability: Resistance to cross-site scripting (XSS), SQL injection, and unauthorized API access attempts. Data Privacy: Verification that PII is encrypted and inaccessible to unauthorized users, ensuring compliance with R.A. 10173. API Security: Rate limiting effectiveness and token expiration handling.

Maintenance Plan	Establish a standardized bug reporting mechanism for neighborhood officials. Conduct quarterly system health checks and security updates. Maintain detailed documentation for adaptive and corrective maintenance. Monitor Netlify Function performance and database optimization.	Reliability: Success rate of daily automated data backups, Netlify Function uptime, and database performance. Stability: Monitoring error logs for recurring bugs, system crashes, or function timeouts. Adaptability: Time required to integrate a minor feature request (e.g., new report category) into the existing codebase. Scalability: Ability to handle increased load through serverless auto-scaling.

The detailed plans above are fundamental to ensuring the system's sustained operation and success. The Test Plan guarantees not only the technical functionality but also the practical usability of the system by its target audience, ensuring quick report times and administrative efficiency as desired in a smart system. The stringent Security Plan is designed to protect all stakeholders by implementing measures like JWT authentication, Google OAuth, and encryption, thereby adhering to legal requirements and ethical responsibilities regarding data privacy (Wolfert et al., 2017). Finally, the Maintenance Plan provides a structured framework for continuous system support, using a process for health checks and systematic bug fixing to ensure the Smart Neighborhood Maintenance System remains a reliable and up-to-date tool for local governance.

GANTT CHART:
[Note: The GANTT chart should reflect the Iterative Model with 6 iterations as outlined in the development lifecycle section above. Each iteration should be shown as a distinct phase with dependencies between iterations.]

PERT CHART:

Activity	Description	Duration (Days)	Predecessor	ES	EF	LS	LF

A	Project Proposal & Planning	9	-	0	9	0	9

B	Requirements Analysis	10	A	9	19	9	19

C	System Design & Architecture	9	B	19	28	19	28

D	Iteration 1: Core Infrastructure	14	C	28	42	28	42

E	Iteration 2: Resident Module	14	D	42	56	42	56

F	Iteration 3: Admin Dashboard	14	E	56	70	56	70

G	Iteration 4: Assignment & Logging	14	F	70	84	70	84

H	Iteration 5: Google Sign-In & Enhancements	14	G	84	98	84	98

I	Iteration 6: Analytics & Reporting	14	H	98	112	98	112

J	Testing and Debugging	15	I	112	127	112	127

K	Deployment and Presentation	10	J	127	137	127	137

DURATION: 137 days
CRITICAL PATH: A,B,C,D,E,F,G,H,I,J,K

Context Diagram:
[Note: The Context Diagram should show the system as the central process, with external entities including: Residents, Officials, Netlify Functions (serverless backend), Supabase PostgreSQL Database, Google Sign-In API, and Email Service. The diagram should illustrate data flows between these entities and the system.]

Data Flow Diagram:
[Note: The Data Flow Diagram should reflect the serverless architecture with the following processes: (1) User Authentication (Resident/Official login, Google OAuth), (2) Request Submission (text classification, photo upload), (3) Request Management (status updates, priority assignment, official assignment), (4) Activity Logging, and (5) Analytics & Reporting. Data stores should include: Users, Officials, Maintenance Requests, Activity Logs, and Media Files. The diagram should show Netlify Functions as the processing layer between the frontend and Supabase database.]

4.3 Description of the Prototype

The Smart Neighborhood Maintenance System was developed as a web-based application designed for accessibility and high usability in local governance. The prototype consists of two distinct software interfaces accessible through modern web browsers:

●	Resident Web Portal: A responsive web application that enables residents to quickly register (via email/password or Google Sign-In), report various maintenance issues (such as faulty lighting, potholes, drainage problems, or damaged sidewalks), upload geo-tagged images for accurate location data, and track the status of their submitted requests in real-time. The interface is optimized for both desktop and mobile browsers, ensuring accessibility across devices.

●	Official Administrative Dashboard: Serving as the central administrative hub for neighborhood officials and dispatchers, the portal provides a comprehensive dashboard featuring a centralized work order queue, request management tools, status update functionality, priority assignment, request assignment to officials, and complete activity logging. Officials authenticate using separate username/password credentials and can view all requests with filtering capabilities, update statuses, set priorities, assign requests to specific officials, and view comprehensive activity logs tracking all actions. The system includes data visualization panels for performance monitoring and analytics. Automated classification suggestions based on keyword matching assist officials in categorizing requests, though manual review and override capabilities are available.

This prototype accurately simulates the entire maintenance workflow from resident reporting to final task closure, ensuring the design is validated for real-world application (Pressman & Maxim, 2020). The system utilizes a serverless architecture with Netlify Functions for production deployment and Supabase PostgreSQL database for data persistence, providing scalability and cost-effectiveness through cloud computing.

Hardware Components

A complete description of the hardware components used during the system's development and testing is provided below. The development environment utilized a combination of computing resources to support tasks such as coding, debugging, database management, and system validation.

Primary computing resources included:

●	Development Laptops (Windows)

○	Various configurations with Intel/AMD processors

○	8-16 GB RAM

○	256-512 GB SSD storage

○	Used for Node.js development, code editing, and local testing

●	Cloud Infrastructure (Netlify Platform)

○	Serverless function execution environment

○	Automatic scaling and CDN distribution

○	No dedicated server hardware required

●	Cloud Database Server (Supabase - PostgreSQL)

○	Hosted on Supabase cloud platform

○	High availability and automatic backups

○	Scalable storage and processing capacity

Development and Testing Environment

●	Local Testing Environment:

○	Node.js runtime for testing Netlify Functions locally using `netlify dev`.

○	Custom Node.js server for serving static files during development.

○	Supabase local development tools for database testing.

●	Production Environment:

○	Netlify platform for hosting static frontend and serverless functions.

○	Supabase cloud PostgreSQL database for persistent data storage.

○	GitHub for version control and CI/CD integration.

●	Data Protection and Storage:

○	Google Drive, OneDrive, and USB storage devices were used for backups and file transfers.

○	GitHub repositories for source code versioning and backup.

●	Internet Connectivity:

○	A stable connection of 10–20 Mbps was required for accessing external libraries, cloud services, collaborative tools, and deployment operations.

The integration of these hardware components and cloud services ensures the system transitions from a simple digitized reporting tool to a sophisticated, data-driven platform capable of intelligently managing neighborhood assets while leveraging modern serverless architecture for scalability and cost-effectiveness.





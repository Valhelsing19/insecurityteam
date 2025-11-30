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

| Plan Type | Actual Plan | What to Assess During Testing |
|-----------|-------------|------------------------------|
| **Test Plan** | Conduct Unit Testing for individual components (Netlify Functions), Integration Testing for API endpoints and database interactions, System Testing across web platforms, and User Acceptance Testing (UAT) with 3 neighborhood officials and 5 residents. | **Functionality:** Correctness of request submission, accuracy of status updates, proper role-based access control, JWT token validation, official assignment functionality, and activity logging. **Performance:** Request submission speed (sub-3 seconds), Netlify Function response times, and concurrent user stability. **Usability:** Ease of use for first-time resident users, administrative efficiency for officials, and mobile responsiveness across devices. **Classification:** Accuracy of rule-based keyword matching for text categorization and priority assignment. |
| **Security Plan** | Enforce strong password hashing (bcrypt), implement JWT token-based authentication with secure storage, utilize input sanitization to prevent common web vulnerabilities (XSS, SQL injection), secure all user PII with encryption (at-rest), and implement Google OAuth security best practices. | **Authentication:** Successful enforcement of JWT token validation, Google Sign-In flow, and password policy. **Vulnerability:** Resistance to cross-site scripting (XSS), SQL injection, and unauthorized API access attempts. **Data Privacy:** Verification that PII is encrypted and inaccessible to unauthorized users, ensuring compliance with R.A. 10173. **API Security:** Rate limiting effectiveness and token expiration handling. |
| **Maintenance Plan** | Establish a standardized bug reporting mechanism for neighborhood officials. Conduct quarterly system health checks and security updates. Maintain detailed documentation for adaptive and corrective maintenance. Monitor Netlify Function performance and database optimization. | **Reliability:** Success rate of daily automated data backups, Netlify Function uptime, and database performance. **Stability:** Monitoring error logs for recurring bugs, system crashes, or function timeouts. **Adaptability:** Time required to integrate a minor feature request (e.g., new report category) into the existing codebase. **Scalability:** Ability to handle increased load through serverless auto-scaling. |

The detailed plans above are fundamental to ensuring the system's sustained operation and success. The Test Plan guarantees not only the technical functionality but also the practical usability of the system by its target audience, ensuring quick report times and administrative efficiency as desired in a smart system. The stringent Security Plan is designed to protect all stakeholders by implementing measures like JWT authentication, Google OAuth, and encryption, thereby adhering to legal requirements and ethical responsibilities regarding data privacy (Wolfert et al., 2017). Finally, the Maintenance Plan provides a structured framework for continuous system support, using a process for health checks and systematic bug fixing to ensure the Smart Neighborhood Maintenance System remains a reliable and up-to-date tool for local governance.

4.2.1 GANTT Chart

The GANTT chart below illustrates the project timeline from September 1 to November 18, 2024, showing the duration and dependencies of each development phase:

| Activity | Description | Start Date | End Date | Duration (Days) | Dependencies |
|----------|-------------|------------|----------|-----------------|--------------|
| A | Requirements Analysis | Sep 1 | Sep 3 | 3 | - |
| B | System Design & Architecture | Sep 4 | Sep 8 | 5 | A |
| C | Iteration 1: Core Infrastructure | Sep 9 | Sep 18 | 10 | B |
| D | Iteration 2: Resident Module | Sep 19 | Sep 28 | 10 | C |
| E | Iteration 3: Admin Dashboard | Sep 29 | Oct 8 | 10 | D |
| F | Iteration 4: Assignment & Logging | Oct 9 | Oct 18 | 10 | E |
| G | Iteration 5: Google Sign-In & Enhancements | Oct 19 | Oct 28 | 10 | F |
| H | Iteration 6: Analytics & Reporting | Oct 29 | Nov 7 | 10 | G |
| I | Testing and Debugging | Nov 8 | Nov 15 | 8 | H |
| J | Deployment and Presentation | Nov 16 | Nov 18 | 3 | I |

**Total Project Duration: 79 days (September 1 - November 18, 2024)**

4.2.2 PERT Chart

The PERT (Program Evaluation and Review Technique) chart below shows the critical path analysis with Early Start (ES), Early Finish (EF), Late Start (LS), and Late Finish (LF) calculations:

| Activity | Description | Duration (Days) | Predecessor | ES | EF | LS | LF | Slack |
|----------|-------------|-----------------|-------------|----|----|----|----|-------|
| A | Requirements Analysis | 3 | - | 0 | 3 | 0 | 3 | 0 |
| B | System Design & Architecture | 5 | A | 3 | 8 | 3 | 8 | 0 |
| C | Iteration 1: Core Infrastructure | 10 | B | 8 | 18 | 8 | 18 | 0 |
| D | Iteration 2: Resident Module | 10 | C | 18 | 28 | 18 | 28 | 0 |
| E | Iteration 3: Admin Dashboard | 10 | D | 28 | 38 | 28 | 38 | 0 |
| F | Iteration 4: Assignment & Logging | 10 | E | 38 | 48 | 38 | 48 | 0 |
| G | Iteration 5: Google Sign-In & Enhancements | 10 | F | 48 | 58 | 48 | 58 | 0 |
| H | Iteration 6: Analytics & Reporting | 10 | G | 58 | 68 | 58 | 68 | 0 |
| I | Testing and Debugging | 8 | H | 68 | 76 | 68 | 76 | 0 |
| J | Deployment and Presentation | 3 | I | 76 | 79 | 76 | 79 | 0 |

**DURATION: 79 days**
**CRITICAL PATH: A → B → C → D → E → F → G → H → I → J**
**All activities are on the critical path (Slack = 0), meaning any delay in any activity will delay the entire project.**

4.2.3 Context Diagram

The Context Diagram represents the system as a single process in its environment, showing all external entities and data flows:

```
                    ┌─────────────────────────────────────┐
                    │                                     │
                    │  Smart Neighborhood Maintenance     │
                    │  Request and Response System        │
                    │                                     │
                    └─────────────────────────────────────┘
                              │
        ┌──────────────────────┬───┼───┬──────────────────────┐
        │                  │   │   │                        │
        ▼                  ▼   ▼   ▼                        ▼
   ┌─────────┐      ┌──────────────┐                  ┌─────────────┐
   │Resident │      │   Official   │                  │   Google    │
   │         │      │              │                  │  Sign-In    │
   │         │      │              │                  │    API      │
   └─────────┘      └──────────────┘                  └─────────────┘
        │                  │                                  │
        │                  │                                  │
        │ Maintenance      │ Request                         │ OAuth
        │ Requests         │ Management                       │ Tokens
        │ Status Updates   │ Assignments                      │
        │                  │ Activity Logs                    │
        │                  │                                  │
        ▼                  ▼                                  ▼
   ┌──────────────────────────────────────────────────────────────┐
   │                                                              │
   │              Netlify Functions (Serverless Backend)          │
   │                                                              │
   └──────────────────────────────────────────────────────────────┘
                              │
                              │ Database Queries
                              │ Data Storage
                              │
                              ▼
                    ┌─────────────────────┐
                    │                     │
                    │  Supabase           │
                    │  PostgreSQL         │
                    │  Database          │
                    │                     │
                    └─────────────────────┘
```

**External Entities:**
- **Resident**: Submits maintenance requests, views status updates
- **Official**: Manages requests, updates status, assigns tasks, views activity logs
- **Google Sign-In API**: Provides OAuth authentication
- **Netlify Functions**: Serverless backend processing layer
- **Supabase PostgreSQL Database**: Data storage and persistence

**Data Flows:**
- Maintenance requests, status updates (Resident ↔ System)
- Request management, assignments, activity logs (Official ↔ System)
- OAuth tokens, user authentication (Google Sign-In API ↔ System)
- Database queries, data storage (System ↔ Supabase Database)

4.2.4 Data Flow Diagram (DFD) - Level 0

The Data Flow Diagram illustrates the system's processes, data stores, and data flows:

```
┌──────────┐
│ Resident │
└────┬─────┘
     │
     │ 1.0 User Authentication
     │    (Login/Register/Google OAuth)
     │
     ▼
┌─────────────────┐         ┌──────────────┐
│  D1: Users      │         │  D2: Officials│
└─────────────────┘         └──────────────┘
     │
     │ 2.0 Request Submission
     │    (Text Classification, Photo Upload)
     │
     ▼
┌──────────────────────────┐
│  D3: Maintenance Requests │
└──────────────────────────┘
     │
     │ 3.0 Request Management
     │    (Status Updates, Priority, Assignment)
     │
     ▼
┌──────────────────────────┐
│  D4: Request Activity Log│
└──────────────────────────┘
     │
     │ 4.0 Analytics & Reporting
     │    (Statistics, Filtering, Visualization)
     │
     ▼
┌──────────┐
│ Official │
└──────────┘
```

**Processes:**
1. **User Authentication**: Handles resident registration, login (email/password), official login (username/password), and Google OAuth authentication
2. **Request Submission**: Processes maintenance request submission, performs rule-based text classification, handles photo/media uploads, and stores requests in database
3. **Request Management**: Manages status updates, priority assignment, official assignment, and updates request records
4. **Activity Logging**: Records all official actions (status changes, priority updates, assignments) in activity log
5. **Analytics & Reporting**: Generates statistics, provides filtering and sorting, and creates data visualizations

**Data Stores:**
- **D1: Users**: Stores resident account information (name, email, password, Google ID, picture)
- **D2: Officials**: Stores official account information (username, password, name, department, position)
- **D3: Maintenance Requests**: Stores all maintenance requests (title, description, location, category, status, priority, assigned_to, media_files)
- **D4: Request Activity Log**: Stores all official actions on requests (action_type, old_value, new_value, description, timestamps)

4.2.5 System Flowchart

The System Flowchart illustrates the main processes and decision points in the system:

```
                    START
                      │
                      ▼
            ┌─────────────────────┐
            │  User Accesses      │
            │  System             │
            └──────────┬──────────┘
                       │
                       ▼
            ┌─────────────────────┐
            │  Login/Register?    │
            └──────────┬──────────┘
                       │
        ┌──────────────┼──────────────┐
        │              │              │
        ▼              ▼              ▼
   ┌────────┐   ┌──────────┐   ┌──────────┐
   │Resident│   │ Official │   │  Google  │
   │ Login  │   │  Login   │   │  Sign-In │
   └───┬────┘   └────┬─────┘   └────┬─────┘
       │             │              │
       └─────────────┼──────────────┘
                     │
                     ▼
            ┌─────────────────────┐
            │  Authentication     │
            │  Successful?        │
            └──────────┬──────────┘
                       │
            ┌───────────┴───────────┐
            │                       │
            NO                      YES
            │                       │
            ▼                       ▼
    ┌──────────────┐      ┌─────────────────┐
    │ Display Error│      │  Check User     │
    │ Return to    │      │  Role           │
    │ Login        │      └────────┬─────────┘
    └──────────────┘               │
                            ┌───────┴────────┐
                            │               │
                            ▼               ▼
                    ┌──────────────┐ ┌──────────────┐
                    │   Resident   │ │   Official   │
                    │   Dashboard  │ │   Dashboard  │
                    └──────┬───────┘ └──────┬───────┘
                           │                │
                           ▼                ▼
                    ┌──────────────┐ ┌──────────────┐
                    │ Submit       │ │ View All     │
                    │ Request      │ │ Requests     │
                    └──────┬───────┘ └──────┬───────┘
                           │                │
                           ▼                ▼
                    ┌──────────────┐ ┌──────────────┐
                    │ Text         │ │ Update       │
                    │ Classification│ │ Status/     │
                    │ (Rule-based) │ │ Priority     │
                    └──────┬───────┘ └──────┬───────┘
                           │                │
                           ▼                ▼
                    ┌──────────────┐ ┌──────────────┐
                    │ Store        │ │ Log Activity │
                    │ Request      │ │ & Update     │
                    │ in Database  │ │ Database     │
                    └──────┬───────┘ └──────┬───────┘
                           │                │
                           └────────┬───────┘
                                    │
                                    ▼
                            ┌──────────────┐
                            │   END        │
                            └──────────────┘
```

4.2.6 Entity Relationship Diagram (ERD)

The Entity Relationship Diagram represents the database structure and relationships:

```
┌─────────────────────────────────────────────────────────────┐
│                         USERS                               │
├─────────────────────────────────────────────────────────────┤
│ PK │ id                    INT                              │
│    │ name                  VARCHAR(255)                     │
│    │ username              VARCHAR(255) UNIQUE NULL         │
│    │ email                 VARCHAR(255) UNIQUE NOT NULL     │
│    │ phone                 VARCHAR(20) NULL                 │
│    │ password              VARCHAR(255) NULL                 │
│    │ address               TEXT NULL                        │
│    │ google_id             VARCHAR(255) UNIQUE NULL         │
│    │ picture               VARCHAR(500) NULL                │
│    │ is_official           TINYINT(1) DEFAULT 0            │
│    │ created_at            TIMESTAMP                        │
│    │ updated_at            TIMESTAMP                        │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ 1
                            │
                            │
                            │ N
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                  MAINTENANCE_REQUESTS                       │
├─────────────────────────────────────────────────────────────┤
│ PK │ id                    INT                              │
│ FK │ user_id               INT NOT NULL                     │
│ FK │ assigned_to           INT NULL                        │
│    │ title                  VARCHAR(255) NOT NULL            │
│    │ description            TEXT NOT NULL                    │
│    │ location               VARCHAR(255) NOT NULL            │
│    │ category               VARCHAR(100) DEFAULT 'general'   │
│    │ status                 ENUM('pending','active',         │
│    │                          'completed','cancelled')        │
│    │ priority               ENUM('low','medium',             │
│    │                          'high','urgent') DEFAULT       │
│    │                          'medium'                       │
│    │ media_files            JSONB DEFAULT '[]'              │
│    │ assigned_at            TIMESTAMP NULL                   │
│    │ created_at             TIMESTAMP                        │
│    │ updated_at             TIMESTAMP                        │
└─────────────────────────────────────────────────────────────┘
         │                              │
         │ N                            │ N
         │                              │
         │                              │
         │                              │
         │                              ▼
         │                    ┌─────────────────────────────────┐
         │                    │    REQUEST_ACTIVITY_LOG        │
         │                    ├─────────────────────────────────┤
         │                    │ PK │ id          INT            │
         │                    │ FK │ request_id  INT NOT NULL   │
         │                    │ FK │ official_id INT NULL      │
         │                    │    │ action_type VARCHAR(50)    │
         │                    │    │ old_value   VARCHAR(255)   │
         │                    │    │ new_value   VARCHAR(255)   │
         │                    │    │ description TEXT NULL      │
         │                    │    │ created_at  TIMESTAMP      │
         │                    └─────────────────────────────────┘
         │                                    │
         │                                    │ N
         │                                    │
         │                                    │
         │                                    │ 1
         │                                    │
         │                                    ▼
         │                    ┌─────────────────────────────────┐
         │                    │         OFFICIALS              │
         │                    ├─────────────────────────────────┤
         │                    │ PK │ id          INT            │
         │                    │    │ username    VARCHAR(255)    │
         │                    │    │            UNIQUE NOT NULL │
         │                    │    │ password    VARCHAR(255)    │
         │                    │    │            NOT NULL        │
         │                    │    │ name        VARCHAR(255)   │
         │                    │    │            NOT NULL        │
         │                    │    │ department  VARCHAR(255)   │
         │                    │    │            NULL           │
         │                    │    │ position    VARCHAR(255)   │
         │                    │    │            NULL           │
         │                    │    │ phone       VARCHAR(20)     │
         │                    │    │            NULL           │
         │                    │    │ email       VARCHAR(255)   │
         │                    │    │            NULL           │
         │                    │    │ is_active   TINYINT(1)     │
         │                    │    │            DEFAULT 1      │
         │                    │    │ created_at  TIMESTAMP     │
         │                    │    │ updated_at  TIMESTAMP     │
         │                    └─────────────────────────────────┘
         │
         │ Relationships:
         │ - USERS (1) ────────< (N) MAINTENANCE_REQUESTS
         │   (One user can submit many requests)
         │
         │ - OFFICIALS (1) ────< (N) MAINTENANCE_REQUESTS
         │   (One official can be assigned many requests)
         │
         │ - MAINTENANCE_REQUESTS (1) ────< (N) REQUEST_ACTIVITY_LOG
         │   (One request can have many activity log entries)
         │
         │ - OFFICIALS (1) ────< (N) REQUEST_ACTIVITY_LOG
         │   (One official can perform many actions)
         └─────────────────────────────────────────────────────┘
```

4.2.7 Database Normalization

The database design follows the principles of database normalization to eliminate redundancy and ensure data integrity:

**First Normal Form (1NF):**
All tables satisfy 1NF as each column contains atomic values (no repeating groups or arrays, except for JSONB media_files which is acceptable in PostgreSQL for flexible data storage).

**Second Normal Form (2NF):**
All tables satisfy 2NF as they are in 1NF and all non-key attributes are fully functionally dependent on the primary key:
- **users**: All attributes depend on `id` (primary key)
- **officials**: All attributes depend on `id` (primary key)
- **maintenance_requests**: All attributes depend on `id` (primary key), with foreign keys `user_id` and `assigned_to` referencing other tables
- **request_activity_log**: All attributes depend on `id` (primary key), with foreign keys `request_id` and `official_id` referencing other tables

**Third Normal Form (3NF):**
All tables satisfy 3NF as they are in 2NF and there are no transitive dependencies (non-key attributes do not depend on other non-key attributes):
- **users**: No transitive dependencies (e.g., `email` does not determine `name`)
- **officials**: No transitive dependencies (e.g., `department` does not determine `position`)
- **maintenance_requests**: No transitive dependencies
- **request_activity_log**: No transitive dependencies

**Normalization Summary:**

| Table | 1NF | 2NF | 3NF | Notes |
|-------|-----|-----|-----|-------|
| users | ✓ | ✓ | ✓ | Fully normalized |
| officials | ✓ | ✓ | ✓ | Fully normalized |
| maintenance_requests | ✓ | ✓ | ✓ | Fully normalized; JSONB media_files is acceptable for flexible storage |
| request_activity_log | ✓ | ✓ | ✓ | Fully normalized |

**Foreign Key Relationships:**
- `maintenance_requests.user_id` → `users.id` (ON DELETE CASCADE)
- `maintenance_requests.assigned_to` → `officials.id` (ON DELETE SET NULL)
- `request_activity_log.request_id` → `maintenance_requests.id` (ON DELETE CASCADE)
- `request_activity_log.official_id` → `officials.id` (ON DELETE SET NULL)

**Indexes for Performance:**
- `users`: `idx_email`, `idx_google_id`
- `officials`: `idx_username`, `idx_is_active`
- `maintenance_requests`: `idx_user_id`, `idx_status`, `idx_priority`, `idx_assigned_to`, `idx_media_files` (GIN index for JSONB)
- `request_activity_log`: `idx_request_id`, `idx_official_id`, `idx_action_type`, `idx_created_at`

4.2.8 Use Case Diagram

The Use Case Diagram illustrates the interactions between actors and the system:

```
                    ┌──────────────────────────────────────┐
                    │                                      │
                    │  Smart Neighborhood Maintenance      │
                    │  Request and Response System        │
                    │                                      │
                    │  ┌──────────────────────────────┐  │
                    │  │ Register Account              │  │
                    │  │ Login (Email/Password)         │  │
                    │  │ Login (Google Sign-In)         │  │
                    │  │ Submit Maintenance Request     │  │
                    │  │ Upload Photos/Media            │  │
                    │  │ View My Requests               │  │
                    │  │ Track Request Status           │  │
                    │  │ Update Profile                 │  │
                    │  └──────────────────────────────┘  │
                    │                                      │
                    │  ┌──────────────────────────────┐  │
                    │  │ Login (Username/Password)      │  │
                    │  │ View All Requests              │  │
                    │  │ Update Request Status          │  │
                    │  │ Set Request Priority           │  │
                    │  │ Assign Request to Official     │  │
                    │  │ View Activity Logs             │  │
                    │  │ Generate Reports               │  │
                    │  │ View Analytics Dashboard        │  │
                    │  │ Filter and Sort Requests       │  │
                    │  └──────────────────────────────┘  │
                    │                                      │
                    └──────────────────────────────────────┘
                              ▲                    ▲
                              │                    │
                              │                    │
                    ┌─────────┘                    └─────────┐
                    │                                        │
                    │                                        │
            ┌───────┴────────┐                    ┌─────────┴────────┐
            │                │                    │                  │
            │   Resident     │                    │    Official      │
            │                │                    │                  │
            └────────────────┘                    └──────────────────┘
```

**Actors:**
1. **Resident**: Community members who submit maintenance requests
2. **Official**: Government staff who manage and process requests

**Resident Use Cases:**
- Register Account (email/password or Google Sign-In)
- Login (Email/Password or Google Sign-In)
- Submit Maintenance Request
- Upload Photos/Media
- View My Requests
- Track Request Status
- Update Profile

**Official Use Cases:**
- Login (Username/Password)
- View All Requests
- Update Request Status
- Set Request Priority
- Assign Request to Official
- View Activity Logs
- Generate Reports
- View Analytics Dashboard
- Filter and Sort Requests

**System Use Cases (Automated):**
- Automated Text Classification (Rule-based keyword matching)
- Activity Logging (Automatic tracking of official actions)
- Email Notifications (Status updates to residents)

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





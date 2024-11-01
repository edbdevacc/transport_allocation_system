EDB TAS (Transport Allocation System)
1. Introduction
1.1 Purpose
The purpose of the Transport Allocation System (TAS) is to automate and streamline the 
process of requesting, approving, and allocating vehicles for various organizational needs. The 
system will ensure efficient resource management by enabling different user roles to request, 
approve, allocate, and monitor vehicle use while maintaining transparent communication via 
notifications.
1.2 Scope
This document specifies the functional and non-functional requirements for the development 
of the TAS. The system will cater to different user roles including Request Officers, Division 
Heads, Transport Officers, Directors, Security Officers, and Drivers, ensuring that all transport 
requests are handled smoothly and efficiently.
1.3 Definitions, Acronyms, and Abbreviations
 TAS: Transport Allocation System
 HRM: Human Resource Management
 DG: Director General
 SMS: Short Message Service
1.4 References
 Company transport policies
 Organizational structure and approval hierarchy
1.5 Overview
This document outlines the system’s purpose, requirements, architecture, and functional design 
for the TAS. It will serve as a guideline for developers and stakeholders to ensure that the 
system meets business objectives.
2. System Overview
3. Functional Requirements
3.1. User Roles and Permissions
The system will have the following roles, each with specific permissions:
1. Request Officer: Can request vehicles, specify travel details, and complete routes.
2. Division Head: Approves or rejects vehicle requests within their division.
3. MA (Transport): Allocates vehicles and drivers, manages routes.
4. Director (HRM): Approves or rejects requests based on policies.
5. Reporter: Handles approvals for special requests (e.g., long-distance, after hours).
6. Security Officer: Logs vehicle dispatch and returns.
7. Driver: Check Assigned to a vehicle for a specific route.
3.2. System Workflow
1. Vehicle Request Process
2. Approval Workflow
3. Vehicle Allocation
4. Vehicle Status Log
3.3. Vehicle Request Process
3.3.1. Vehicle Request from Request Officer (EDB Officers)
Request Officer fills a form with the following details:
a. Employee Type (Optional)
 Foreign
 Staff 
 Other Special
b. User Amount (Optional)
 Group
 Individual
c. Transport Type (optional)
 Before Office(Before 8.15 AM)
 Day Duties (Before 4.15 PM)
 After Office (After 6 PM)
 Outstation (Events / Programs)
d. Other Details
 Name, Designation, Mobile, Extension , Division (Auto)
 If user Amount Group – Other Participants Details, amount 
 Time Duration (From , To)
 Route Details (Pickup , Drop)
 Approximate Distance 
 Reason for Request
 Submit Date (auto)
 If Outstation - Program approval ID
Business Rules:
 Only eligible users can apply (Directors are excluded).
 Requests after 6 PM, before 8.15 AM or for distances > 50 km require DG 
approval.
 An auto-generated submission date is captured.
 After Submit form need send SMS to related officer
3.4. Approval Workflow
3.4.1. Division Head Approval
 Division Head Get action with the following details:
a. Allocate on other Officer
b. Approve/ Reject/ Pending
c. If Special Request (After Office or 50Km > distance) Send Director 
General
d. If Reject, Reason for it
e. Date (auto)
 Business Rules:
 Options: Approve, Reject, or Pending
 If assigned job another officer, Send SMS to related officer
 Upon approval/rejection, send SMS/Email notifications to HR Director.
3.4.2. HR Director Approval
 Division Head Get action with the following details:
a. Allocate on other Officer
b. Approve/ Reject/ Pending
c. If Special Request (After Office or 50Km > distance) Get Director General
Approval & Attach Document
d. If Reject, Reason for it
e. Date (auto)
 Business Rules:
 Approves or rejects requests, with special handling for after office, before office, or 
long-distance requests & Attach DG Approval.
 If approve or Reject, send SMS/Email to Transport Officer (MA)
 If assigned job another officer, Send SMS/Email to related officer
3.5. Vehicle Allocation
3.5.1. MA (Transport) Vehicle Allocation
 Transport Officer Get action with the following details:
a. Check Eligibility Employee List
b. Check available Driver List
c. Check available Vehicle List
d. Check Exist approved routes and free seats
e. Assign Job other Officer (If need )
f. Allocate Transport
 Update Route
 Assign Driver
 Allocate Vehicle and Update available seat count
g. Add note (Optional)
h. Attach approval Documents
i. Submit Allocated Vehicle
j. If reject need add reason
k. Date (auto)
Business Rules:
 Checks driver, vehicle, and route availability.
 Assigns a vehicle and driver.
 Manages seat counts and route details.
 If Outstation, Check event approvals
 Sends SMS/Email notifications to the driver, HR Director, and relevant officers.
3.6. Vehicle Status Log
3.6.1. Security Officer Update Log
 Security Officer Logs vehicle dispatch, return times, and updates vehicle status.
a. Submit Log vehicle availability
 Vehicle Number
 Vehicle dispatcher Time
 Vehicle return Time
 Driver name
Business Rules:
 Update Vehicle available status and Driver status
4. Non-Functional Requirements
4.1 Performance Requirements
 The system must handle multiple simultaneous requests without performance 
degradation.
 All operations (submitting forms, generating approvals, allocating vehicles) should be 
completed efficiency.
4.2 Usability
 The system should be user-friendly and intuitive.
 It must be accessible from any device (PC or mobile).
4.3 Security
 All users must authenticate before accessing the system.
 Only authorized roles should have access to specific functionalities (e.g., MA can 
allocate vehicles, but Request Officers cannot).
 SMS/Email notifications should be sent over secure channels.
4.4 Reliability and Availability
 Data integrity must be maintained in case of system failure (e.g., unfinished requests 
should be saved as drafts).
4.5 Scalability
 The system should be scalable to accommodate additional users or roles if needed.
4.6 Maintainability
 The system should be easy to maintain, with modular components to allow for easy 
updates or modifications.
 Logs of all activities should be maintained for auditing.
5. System Architecture
The TAS will be a web-based application with a modular architecture. Key components will 
include:
 User Interface (UI): A responsive web interface for all user interactions.
 Backend Services: Handles all business logic, including vehicle allocation, approvals, 
and SMS/Email notifications.
 Database: Stores all request data, approvals, vehicle availability, route logs, and user 
roles.
5.1 User Interface
 Forms for submitting vehicle requests and Vehicle Status.
 Dashboards for viewing pending approvals and allocations.
 Tables for viewing available drivers, vehicles.
5.2 Backend Services
 Business logic layer to validate requests, process approvals, allocate vehicles, and 
trigger notifications.
 SMS/ Email service integration for real-time updates.
5.3 Database
 Entities:
o Users (roles, permissions)
o Vehicles (availability, status)
o Requests (details, status)
o Routes (distance, time, pickup/drop points)
6. Conclusion
This SRS document provides a detailed description of the EDB Transport Allocation System
(EDB TAS). It specifies the system’s functional and non-functional requirements, roles, 
workflows, and architecture. This document will serve as a blueprint for development, ensuring 
that the final product meets the organization's needs.

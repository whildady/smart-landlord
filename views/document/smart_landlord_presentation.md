project: "Smart Landlord: Enterprise Property Management System"
context: "University Final-Year Project Presentation"
objectives:
  - "Automate rental operations"
  - "Ensure financial auditability"
  - "Standardize property lifecycle maintenance"

presentation_slides:
  - slide: 1
    title: "Executive Summary"
    points:
      - "The Tanzanian rental sector faces challenges in tracking pro-rata utility costs and managing lease compliance."
      - "Smart Landlord is a web-based solution designed to bridge the gap between landlords and tenants through data-driven automation."
      - "Focus on high-availability, maintainability, and user-centric design."

  - slide: 2
    title: "System Architecture (The Technology Stack)"
    infrastructure:
      - "Backend: Yii2 Framework (PHP) implementing MVC design patterns."
      - "Database: MySQL (Relational storage for transactional integrity)."
      - "Frontend: Tailwind CSS, Lucide Icons, and responsive design for mobile/desktop accessibility."
      - "Security: CSRF protection, Role-Based Access Control (RBAC), and session-based authentication."

  - slide: 3
    title: "Database Strategy (Logical Tiers)"
    schema_breakdown:
      Identity_Management:
        tables: ["users", "system_settings"]
        purpose: "Handles authentication and global configuration (e.g., VAT rates, tax settings)."
      Asset_Inventory:
        tables: ["properties", "units", "tenants", "lease_agreements"]
        purpose: "Tracks the rental hierarchy from the physical asset to the legal occupant."
      Financial_Ledger:
        tables: ["invoices", "payments", "expenses", "utility_bills", "utility_splits"]
        purpose: "Ensures financial transparency by separating billing, collection, and split-cost calculations."
      Operational_Lifecycle:
        tables: ["maintenance_tasks", "messages", "notice_broadcasts", "calendar_event", "document_cloud"]
        purpose: "Digital communication and asset upkeep workflows."

  - slide: 4
    title: "Deep Dive: The Financial Engine"
    core_logic:
      invoices: "Generates pending debt based on rent or utility usage."
      payments: "Records settlement of debt with time-stamping for audit trails."
      utility_splits: "The logic engine that calculates individual unit consumption, preventing overcharging."
    academic_significance: "Demonstrates relational data modeling—linking payments directly to specific invoices to eliminate record discrepancies."

  - slide: 5
    title: "System Maintenance & Scalability"
    highlight: "Dynamic 'System Settings' Configuration"
    explanation: |
      Instead of hardcoding business rules, the `system_settings` table uses a Key-Value pair storage architecture.
      This allows the landlord to adjust tax rates, interest penalties, or notification thresholds dynamically 
      without modifying the core database schema or redeploying code.

  - slide: 6
    title: "The 'Smart' Component (Operational Automation)"
    automation_features:
      - "Notice Broadcasts: Batch communication for maintenance updates or community alerts."
      - "Document Cloud: Secure storage and iframe-based retrieval of legally binding contracts."
      - "Maintenance Tasks: Lifecycle management (Open -> In Progress -> Resolved), providing a clear audit of property condition."

  - slide: 7
    title: "Conclusion & Future Scope"
    summary: "The system provides a robust, scalable foundation for property management."
    future_work:
      - "Integration with TRA (Tanzania Revenue Authority) via API for automatic tax filing."
      - "Mobile Application for tenants for real-time payment status tracking."
      - "Big Data Analytics: Predicting tenant churn and property demand using historical lease data."
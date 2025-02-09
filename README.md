# Usage Summary

- Entry Point (index.php): Routes incoming HTTP requests to the appropriate controller based on the URI and request method.
- Global Settings (global.php): Sets headers, timezone, session handling, and includes shared configurations.
- Database Configuration (config/database.php): Manages the PDO connection using a singleton pattern.
- Models (model/): Provide data access methods. Extend BaseModel for shared database access.
- Controllers (controller/): Handle HTTP requests and responses, using models to interact with the database.
- Authentication Utilities (authUtils.php): (Optional) Provide methods for validating requests and enforcing authorization.

---

This backend template is independent of any frontend technology. It exposes a RESTful API that you can connect to any frontend (React, Angular, Vue, etc.) or even mobile clients.

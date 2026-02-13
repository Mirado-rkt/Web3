# Takalo-takalo - Complete Application Map

## 🗺️ User Journey Map

```
┌─────────────────────────────────────────────────────────────────┐
│                          HOME PAGE (/)                          │
│                                                                 │
│  [S'inscrire] [Se connecter]  OR  [Objets] [Autres menus...]  │
└──────────────────┬──────────────────────────────────────────────┘
                   │
         ┌─────────┴──────────┐
         │                    │
         ▼                    ▼
    [Register]           [Login]
      /register            /login
         │                    │
         │                    │
    Create Account    Enter Credentials
         │                    │
         └─────────┬──────────┘
                   │
                   ▼
        ┌──────────────────────┐
        │   MAIN APP            │
        │  (Authenticated)     │
        └──────────┬───────────┘
                   │
      ┌────────────┼──────────────┬──────────────┐
      │            │              │              │
      ▼            ▼              ▼              ▼
   Browse    Add Item      Manage Items     Proposals
   /items    /item/new     /my/items        /exchanges
      │            │              │              │
      │            │              │              │
   Search &    Upload        View/Edit      Accept/
   Filter      Multiple      Delete         Refuse
   By:         Photos        Items          Exchange
   - Keyword   From:                        Proposals
   - Category  - Upload
              - Assets
```

---

## 🏗️ Directory Structure with Purpose

```
/home/mirindra/Documents/Web3/
│
├── 📄 PUBLIC FILES (Accessed in browser)
│   └── public/
│       ├── index.php (Application entry point)
│       ├── uploads/ (User-uploaded photos location)
│       └── assets/
│           └── images/ (Predefined helmet photos)
│
├── 🗄️ DATABASE
│   └── database/
│       └── database.sql (Schema + seed data)
│
├── 🎯 APPLICATION CODE
│   └── app/
│       ├── models/
│       │   ├── User.php (Authentication, count users)
│       │   ├── Item.php (Search, list, create items)
│       │   ├── Photo.php (Multi-photo management)
│       │   ├── Category.php (Category CRUD)
│       │   └── Exchange.php (Proposals, acceptance, history)
│       │
│       ├── controllers/
│       │   ├── AuthController.php (Register, login)
│       │   ├── ItemController.php (List, search, view items)
│       │   ├── ItemManagementController.php (Create item with photos)
│       │   ├── ExchangeController.php (Propose, accept, refuse)
│       │   ├── AdminController.php (Dashboard, stats)
│       │   ├── CategoryController.php (Category management)
│       │   └── ApiExampleController.php (Example API)
│       │
│       ├── config/
│       │   ├── routes.php (All URL mappings)
│       │   ├── services.php (Service definitions)
│       │   ├── bootstrap.php (App initialization)
│       │   └── config.php (Database connection)
│       │
│       ├── views/
│       │   ├── layout/
│       │   │   └── base.php (Main HTML template with CSS)
│       │   ├── welcome.php (Homepage)
│       │   ├── login.php (User login)
│       │   ├── register.php (User registration)
│       │   ├── item_form.php (Add/edit item form)
│       │   ├── item_detail.php (View item + propose exchange)
│       │   ├── objets_list.php (Search/browse items)
│       │   ├── my_items.php (User's items)
│       │   ├── exchanges_list.php (Manage proposals)
│       │   └── admin/
│       │       ├── login.php (Admin login)
│       │       ├── dashboard.php (Statistics)
│       │       ├── categories.php (Category list)
│       │       └── category_create.php (Create category)
│       │
│       ├── middlewares/
│       │   └── SecurityHeadersMiddleware.php
│       │
│       ├── utils/
│       │   ├── Session.php (Session management)
│       │   └── ViewHelper.php (Template rendering)
│       │
│       └── commands/
│           └── SampleDatabaseCommand.php
│
├── 📚 DOCUMENTATION
│   ├── README.md (Original readme)
│   ├── QUICK_START.md (3-step quick start)
│   ├── DEPLOYMENT_GUIDE.md (Setup instructions)
│   ├── IMPLEMENTATION_STATUS.md (Feature list)
│   ├── FINAL_SUMMARY.md (Technical details)
│   └── EXECUTIVE_SUMMARY.md (High-level overview)
│
├── 🔧 CONFIGURATION
│   ├── composer.json (Dependencies)
│   ├── index.php (App bootstrap)
│   └── .gitignore (Git ignore rules)
│
└── 📦 VENDOR (Composer packages)
    └── vendor/
        ├── flightphp/ (Flight framework)
        ├── autoload.php (Auto-loading)
        └── ...
```

---

## 🔀 Routing Map

```
PUBLIC ROUTES (No login required)
├── GET  /                          → Homepage
├── GET  /register                  → Registration form
├── POST /register                  → Process registration
├── GET  /login                     → Login form
├── POST /login                     → Process login
├── GET  /logout                    → Logout
├── GET  /items                     → Browse items (with search/filter)
└── GET  /items/{id}                → Item detail + exchange form

AUTHENTICATED USER ROUTES
├── GET  /my/items                  → My items
├── GET  /item/new                  → Add item form
├── POST /item/save                 → Create item (with photos)
├── GET  /item/manage/{id}          → Item management detail
├── POST /exchanges/propose         → Send exchange proposal
├── GET  /exchanges                 → Incoming proposals
├── POST /exchanges/{id}/accept     → Accept proposal
└── POST /exchanges/{id}/refuse     → Refuse proposal

ADMIN ROUTES
├── GET  /admin/login               → Admin login form
├── POST /admin/login               → Process admin login
├── GET  /admin/logout              → Admin logout
├── GET  /admin                     → Dashboard (with stats)
├── GET  /admin/categories          → Category list
├── GET  /admin/categories/new      → Create category form
├── POST /admin/categories/new      → Create category
└── GET  /admin/categories/delete/{id} → Delete category

API EXAMPLE ROUTES (Reference)
├── GET  /api/users                 → List users (API)
├── GET  /api/users/{id}            → Get user (API)
└── POST /api/users/{id}            → Update user (API)
```

---

## 💾 Database Table Schema

```
users
├── id (PK)
├── name
├── email (UNIQUE)
├── password (hashed)
├── is_admin (boolean)
└── created_at

categories
├── id (PK)
├── name (UNIQUE)
└── [no timestamps needed]

items
├── id (PK)
├── owner_id (FK → users.id)
├── category_id (FK → categories.id)
├── title
├── description
├── estimated_price
└── created_at

photos
├── id (PK)
├── item_id (FK → items.id)
├── file_path
└── created_at

exchanges
├── id (PK)
├── proposer_id (FK → users.id)
├── proposer_item_id (FK → items.id)
├── target_owner_id (FK → users.id)
├── target_item_id (FK → items.id)
├── status (pending/accepted/refused)
├── created_at
└── updated_at

item_history
├── id (PK)
├── item_id (FK → items.id)
├── previous_owner_id (FK → users.id)
├── new_owner_id (FK → users.id)
└── exchanged_at
```

---

## 🔄 Data Flow Diagram

```
REQUEST
  │
  ├─→ Router (routes.php)
  │     │
  │     ├─→ Middleware (SecurityHeaders)
  │     │
  │     └─→ Controller (e.g., ItemController)
  │           │
  │           ├─→ Get data from Models
  │           │     │
  │           │     └─→ Database (PDO + Prepared Statements)
  │           │
  │           ├─→ Check authorization (Session)
  │           │
  │           └─→ Pass data to View
  │                 │
  │                 ├─→ Render template
  │                 │
  │                 └─→ HTML output
  │
  └─→ RESPONSE (HTML to browser)
```

---

## 🎛️ Controller Responsibilities

```
AuthController
└── Handles: User registration, login, logout
    Uses: User model, Session utility
    Views: login.php, register.php

ItemController
└── Handles: List items, search, view details, get my items
    Uses: Item, Photo, Category models
    Views: objets_list.php, item_detail.php, my_items.php

ItemManagementController
└── Handles: Create item, select multiple photos
    Uses: Item, Photo, Category models
    Output: Photos to /public/uploads/ + DB records
    Views: item_form.php

ExchangeController
└── Handles: Propose, accept, refuse exchanges
    Uses: Exchange, Item models
    Side Effects: Updates items.owner_id, creates item_history
    Views: exchanges_list.php

AdminController
└── Handles: Admin login, dashboard display
    Uses: User, Exchange models
    Checks: Admin session flag
    Views: admin/login.php, admin/dashboard.php

CategoryController
└── Handles: List, create, delete categories
    Uses: Category model
    Checks: Admin auth
    Views: admin/categories.php, admin/category_create.php
```

---

## 🎨 View Template Hierarchy

```
layout/base.php (Main wrapper)
├── Contains: HTML structure, CSS styles, navigation, footer
├── Includes: Header with logo and menu
├── Includes: Container with dynamic content
└── Includes: Footer with credits

Views (rendered into layout/base.php)
├── welcome.php
│   └── Hero section + feature cards
│
├── login.php, register.php
│   └── Form cards with validation messages
│
├── item_form.php
│   └── Form with category dropdown + photo uploader
│
├── item_detail.php
│   └── Item info + photo gallery + history table + exchange form
│
├── objets_list.php
│   └── Search form + item grid with search/filter
│
├── my_items.php
│   └── User's item grid with edit/delete buttons
│
├── exchanges_list.php
│   └── Table of proposals with action buttons
│
└── admin/
    ├── login.php → Admin login form
    ├── dashboard.php → Stats cards
    ├── categories.php → Category table
    └── category_create.php → Category form
```

---

## 🔐 Security Flow

```
USER INPUT
  │
  ├─→ Controller receives request
  │
  ├─→ Check authentication (Session)
  │
  ├─→ Check authorization (Session admin flag / owner verification)
  │
  ├─→ Sanitize input (trim, type casting)
  │
  ├─→ Prepare database query (Parameter binding)
  │     └─→ Prevents SQL injection
  │
  ├─→ Execute query
  │
  ├─→ Process response
  │
  └─→ Render in view
      └─→ Escape output (htmlspecialchars)
          └─→ Prevents XSS
```

---

## 📊 Data Lifecycle Example: Adding an Item

```
1. USER navigates to /item/new
   │
   ├─→ ItemManagementController::showForm()
   │     ├─ Check Session (must be logged in)
   │     ├─ Load categories from Category::all()
   │     └─ Render item_form.php with $categories
   │
2. USER fills form + selects photos
   │
3. USER submits POST to /item/save
   │
   ├─→ ItemManagementController::save()
   │     ├─ Get user from Session
   │     ├─ Validate title (required)
   │     ├─ Call Item::create() → returns $itemId
   │     ├─ Process uploaded files
   │     │   └─→ Move to /public/uploads/
   │     ├─ For each photo (uploaded or existing)
   │     │   └─→ Call Photo::create($itemId, $filePath)
   │     ├─ Set success flash message
   │     └─ Redirect to /my/items
   │
4. DATABASE state change
   │   items table: New row added
   │   photos table: Multiple rows added (one per photo)
   │   /public/uploads/: New files appear
   │
5. USER sees new item in /my/items
   │
   ├─→ ItemController::myItems()
   │     ├─ Get user ID from Session
   │     ├─ Call Item::findByOwner($userId)
   │     ├─ For each item, call Photo::findByItem($itemId)
   │     └─ Render my_items.php with items + photos
```

---

## 🎯 Exchange Workflow

```
USER A (Owner of Item A) sees Item B (owned by User B)
  │
  └─→ Click "Proposer un échange"
      │
      └─→ Select one of User A's items from dropdown
          │
          └─→ POST /exchanges/propose
              │
              └─→ ExchangeController::propose()
                  ├─ Check Session (User A logged in)
                  ├─ Validate: $proposer_item_id, $target_item_id, $target_owner_id
                  ├─ Call Exchange::create($proposer_id, $proposer_item_id, $target_owner_id, $target_item_id)
                  │   └─→ Insert into exchanges table (status='pending')
                  ├─ Set flash success
                  └─ Redirect to /items

USER B views proposals at /exchanges
  │
  └─→ ExchangeController::proposals()
      ├─ Get User B from Session
      ├─ Call Exchange::findByTargetOwner($user_b_id)
      │   └─→ Returns list with proposer name, both items, status
      └─ Render exchanges_list.php

USER B clicks "Accepter" for exchange with ID=5
  │
  └─→ POST /exchanges/5/accept
      │
      └─→ ExchangeController::accept(5)
          ├─ Get User B from Session
          ├─ Call Exchange::find(5) → Check User B owns target item
          ├─ Call Exchange::updateStatus(5, 'accepted')
          │   ├─ Update exchanges table SET status='accepted'
          │   ├─ Get exchange details
          │   ├─ Create item_history record
          │   │   └─→ Records: item_id, previous_owner_id, new_owner_id, exchanged_at
          │   └─→ Update items_table SET owner_id=proposer_id (Item B now owned by User A)
          ├─ Set flash success
          └─ Redirect to /exchanges

RESULT: Items swapped, history recorded, ownership updated
```

---

## 🎨 CSS Color Application

```
Blue Theme (#1e40af, #3b82f6)
├── Body background: Linear gradient (light to dark blue)
├── Logo color: Blue
├── Primary buttons: Blue
├── Form focus border: Blue
├── Link colors: Blue
└── Hover effects: Blue tones

Yellow Accent (#fcd34d, #fbbf24)
├── Register/Sign-up buttons: Yellow
├── Button hover state: Yellow/darker
└── Secondary CTAs: Yellow

Status Indicators
├── Pending: Yellow background
├── Accepted: Green background
├── Refused: Red background
└── Neutral: Gray background
```

---

## 📈 Scalability Considerations

**Current Design**:
- ✅ Normalized database schema (good for scaling)
- ✅ Parameterized queries (good for security)
- ✅ Model-based architecture (good for maintenance)

**Future Improvements**:
- Add database indexing on search fields (items.title, items.description)
- Implement caching for categories and popular items
- Add pagination to item lists (currently loads all)
- Move file storage to cloud (S3, Azure Blob)
- Add database replication for redundancy
- Implement message queue for async operations

---

## ✅ Testing Strategy

```
Unit Tests Needed
├── User model: findByEmail, create, count
├── Item model: search, findByOwner
├── Exchange model: updateStatus (ownership transfer)
└── Models: All database methods

Integration Tests Needed
├── Auth flow: Register → Login → Logout
├── Item flow: Add → Search → View → Propose
├── Exchange flow: Propose → Accept → Verify ownership
└── Admin flow: Login → View stats → Manage categories

E2E Tests (Browser)
├── Complete user journey
├── Complete admin journey
└── Visual regression testing
```

This completes the entire application map!

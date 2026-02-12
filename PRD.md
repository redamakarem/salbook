# Product Requirements Document (PRD)

## Project: SalonFlow

**Version:** 1.0  
**Date:** February 2026  
**Status:** Draft

---

## 1. Executive Summary

SalonFlow is a multi-tenant, subscription-based SaaS backend platform designed for salons and beauty spas to manage their services, products, bookings, and operations. Built with Laravel, it provides a robust API (via Laravel Sanctum) for a companion mobile application.

---

## 2. Problem Statement

Salons and beauty spas currently lack an intuitive, unified platform to manage their services, products, and bookings. Many existing solutions are overly complex, expensive, or lack proper mobile integration. SalonFlow aims to provide a streamlined, affordable solution with a modern mobile-first approach.

---

## 3. Target Audience

- **Primary:** Salon and spa owners/managers
- **Secondary:** Employees (stylists, therapists, staff)
- **Tertiary:** End customers booking appointments

---

## 4. Product Overview

| Attribute | Details |
|-----------|---------|
| **Type** | Web-based Backend + REST API |
| **Framework** | Laravel (PHP) |
| **Authentication** | Laravel Sanctum |
| **Architecture** | Multi-tenant SaaS |
| **Tenant Isolation** | Shared database with tenant_id scoping |
| **Domain Strategy** | Custom domain per tenant |
| **Business Model** | Subscription billing (3-tier) |

---

## 5. User Roles & Permissions

| Role | Description | Access Level |
|------|-------------|--------------|
| **Platform Super Admin** | Manages all tenants, subscriptions, platform settings | Full system access |
| **Tenant Admin** | Salon/spa owner or manager | Full tenant access |
| **Employee** | Stylists, therapists, staff members | Limited to assigned tasks and schedule |
| **Customer** | End users booking appointments | Self-service only (via API) |

---

## 6. Core Features

### 6.1 Customer Management (CRUD)
- Customer profile creation and management
- Contact information and preferences
- Booking history
- Notes and special requirements

### 6.2 Service Management
- Service categories (hair, nails, spa, etc.)
- Service definitions with:
  - Name, description
  - Duration
  - Base price
  - Assigned staff capabilities
- Service availability rules

### 6.3 Product Inventory
- Product catalog with categories
- Stock level tracking
- Low stock alerts
- Product pricing
- Cost and margin tracking

### 6.4 Appointment/Booking System (Enhanced)
- Date and time selection
- Service selection
- Staff preference selection
- Add-ons and upgrades
- Notes and special requests
- Deposit payment
- Booking confirmation
- Rescheduling and cancellation

### 6.5 Employee Management
- Staff profiles (name, role, specialties)
- Working hours and availability
- Service assignments
- Commission tracking
- Performance metrics

### 6.6 Billing & Payments (Hybrid Model)
- Online deposit payments
- In-person payment recording
- Invoice generation
- Payment history
- Refund processing

### 6.7 Promotions & Offers
- Discount codes (fixed/percentage)
- Seasonal promotions
- Loyalty program points
- First-time customer offers
- Package deals

### 6.8 Reporting & Analytics
- **Revenue Reports:** Daily/weekly/monthly sales breakdown
- **Booking Analytics:** Popular services, peak times, conversion rates
- **Inventory Reports:** Stock levels, low stock alerts, turnover
- **Employee Reports:** Individual performance, revenue per employee

---

## 7. Technical Requirements

### 7.1 Stack
| Component | Technology |
|-----------|------------|
| Backend Framework | Laravel (latest) |
| API Authentication | Laravel Sanctum |
| Database | MySQL |
| Cache | Redis |
| Queue | Laravel Queue (Redis/Database) |

### 7.2 Multi-Tenancy
- Shared database with `tenant_id` column on all tenant-scoped tables
- Custom domain mapping per tenant
- Tenant context resolution middleware
- Tenant-scoped queries via global scopes

### 7.3 API Design
- RESTful API architecture
- Versioned endpoints (e.g., `/api/v1/`)
- JSON responses
- Proper HTTP status codes
- Rate limiting per tenant

### 7.4 Authentication & Authorization
- Email + password authentication
- Role-based access control (RBAC)
- API token management via Sanctum
- Password reset functionality

---

## 8. Notification System

| Channel | Use Cases |
|---------|-----------|
| Email | Booking confirmations, reminders, receipts, password reset |

---

## 9. Subscription Model

### 9.1 Pricing Tiers

| Tier | Features | Limits |
|------|----------|--------|
| **Basic** | Core features, booking, customer management | 1-5 staff, 50 bookings/month |
| **Pro** | All Basic + inventory, reports, promotions | 20 staff, 500 bookings/month |
| **Enterprise** | All Pro + priority support, custom domain | Unlimited |

### 9.2 Billing
- Recurring subscription (monthly/yearly)
- Stripe integration for payment processing
- Invoice generation
- Grace period for failed payments
- Subscription status management

---

## 10. Tenant Onboarding Flow

1. **Account Creation** - Sign up with email/password
2. **Business Setup** - Enter business name, address, contact info
3. **Branding Setup** - Upload logo, set brand colors
4. **Service Catalog Setup** - Add services with prices and durations
5. **Staff Onboarding** - Add employees and assign services
6. **Domain Configuration** - Set up custom domain
7. **Go Live** - Activate subscription

---

## 11. API Endpoints Overview

### Authentication
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/logout`
- `POST /api/v1/auth/forgot-password`
- `POST /api/v1/auth/reset-password`

### Customers
- `GET /api/v1/customers`
- `POST /api/v1/customers`
- `GET /api/v1/customers/{id}`
- `PUT /api/v1/customers/{id}`
- `DELETE /api/v1/customers/{id}`

### Services
- `GET /api/v1/services`
- `POST /api/v1/services`
- `GET /api/v1/services/{id}`
- `PUT /api/v1/services/{id}`
- `DELETE /api/v1/services/{id}`

### Products
- `GET /api/v1/products`
- `POST /api/v1/products`
- `GET /api/v1/products/{id}`
- `PUT /api/v1/products/{id}`
- `DELETE /api/v1/products/{id}`

### Appointments
- `GET /api/v1/appointments`
- `POST /api/v1/appointments`
- `GET /api/v1/appointments/{id}`
- `PUT /api/v1/appointments/{id}`
- `DELETE /api/v1/appointments/{id}`

### Employees
- `GET /api/v1/employees`
- `POST /api/v1/employees`
- `GET /api/v1/employees/{id}`
- `PUT /api/v1/employees/{id}`
- `DELETE /api/v1/employees/{id}`

### Bookings (Customer-facing)
- `GET /api/v1/available-slots`
- `POST /api/v1/book`
- `GET /api/v1/bookings/{reference}`

---

## 12. Data Models (High-Level)

### Tenant
- id, name, domain, subdomain, logo, brand_colors, subscription_id, status

### User
- id, tenant_id, name, email, password, role, phone, avatar

### Customer
- id, tenant_id, name, email, phone, notes, preferences

### Service
- id, tenant_id, category_id, name, description, duration, price, is_active

### Product
- id, tenant_id, category_id, name, description, sku, price, cost, stock_quantity

### Employee
- id, tenant_id, user_id, specialties, working_hours, commission_rate

### Appointment
- id, tenant_id, customer_id, employee_id, service_id, datetime, duration, status, notes, deposit_amount

### Promotion
- id, tenant_id, code, type, value, start_date, end_date, usage_limit

---

## 13. Timeline

**Target:** Fast track (< 1 month for MVP)

### Suggested Phases

| Phase | Duration | Deliverables |
|-------|----------|--------------|
| **Phase 1** | Week 1 | Project setup, multi-tenancy, auth, user management |
| **Phase 2** | Week 1-2 | Customer, Service, Product CRUD |
| **Phase 3** | Week 2-3 | Employee management, Booking system |
| **Phase 4** | Week 3 | Billing, Promotions, Reports |
| **Phase 5** | Week 3-4 | Subscription system, Onboarding, Testing |

---

## 14. Success Criteria

- [ ] Multi-tenant architecture functional with custom domain support
- [ ] All CRUD operations for customers, services, products, employees
- [ ] Booking flow end-to-end working
- [ ] Payment integration (deposits) operational
- [ ] Subscription billing working
- [ ] Email notifications functional
- [ ] API documentation complete
- [ ] All API endpoints tested and secured

---

## 15. Out of Scope (MVP)

- SMS notifications
- Third-party calendar integrations
- Accounting software integrations
- Marketing tool integrations
- Native mobile app (separate project)

---

## 16. Risks & Mitigation

| Risk | Mitigation |
|------|------------|
| Tight timeline | Prioritize core features, defer nice-to-haves |
| Multi-tenancy complexity | Use proven packages (e.g., spatie/laravel-multitenancy) |
| Payment compliance | Use Stripe to handle PCI compliance |

---

## 17. Open Questions

1. Specific Stripe account/region for payments?
2. Preferred email service provider (Mailgun, SES, etc.)?
3. Specific Laravel version preference?
4. Testing framework preference (Pest, PHPUnit)?

---

*Document created: February 2026*

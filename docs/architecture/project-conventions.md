# Project conventions

1. Blade views contain presentation logic only.
2. Livewire render methods must not contain business logic.
3. Business operations use Actions or Domain Services.
4. Controllers and Livewire components remain thin.
5. Validation uses Form Requests or Livewire validation objects.
6. Authorization must be enforced in backend policies or services.
7. Financial writes must use database transactions.
8. Posted accounting records will be immutable.
9. Money must never be stored as float.
10. Monetary database fields will use `DECIMAL(20, 4)` unless documented otherwise.
11. Dates and times are stored consistently.
12. Tenant context must never be inferred from user input alone.
13. Queue jobs must explicitly initialize tenant context.
14. Cache keys must include tenant context when tenant-specific.
15. Files must use tenant-isolated paths.
16. Domain services must be testable independently.
17. No direct balance columns will become the financial source of truth.
18. General Ledger will become the final financial source of truth.

## Money and data conventions
Monetary values use DECIMAL, never FLOAT or DOUBLE. Exchange rates may use higher precision. Quantities and property areas require module-specific precision rules. Public references must not expose predictable sensitive IDs. Tables use timestamps. Soft deletes are not automatically allowed for financial records, and posted financial records will never be soft-deleted. Unique constraints must include ownership scope. Indexing must consider tenant, company, branch, date, status, document number, account, party, project, and property dimensions.

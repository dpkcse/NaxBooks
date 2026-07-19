# Frontend architecture guidelines

The frontend developer owns an accessible Tailwind design system and Blade/Livewire component library: responsive application shell, tenant/company/branch selectors, forms, tables, filters, pagination, loading/empty/error states, modals, status badges, printable screens and mobile workflows. Alpine is limited to local presentation behavior; Blade contains no business rules.

## Contract
Backend supplies authorized, already-scoped view models/options, validation errors, lifecycle capability flags and pagination/filter contracts. Livewire components remain thin and call actions/services; every action rehydrates IDs through scoped queries and policies. UI may select an authorized workspace/company/branch but never sends a trusted `tenant_id`, asserts company ownership, authorizes itself, changes lifecycle state, provisions a tenant, or treats client accounting arithmetic as source of truth. Accessibility baseline: semantic labels, keyboard modal flow, focus/error announcement, contrast, and responsive checks. QA verifies the visible states; backend owns authorization regardless of what the UI hides.

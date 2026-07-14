# Contributing

- Branch naming: `feature/short-description`, `fix/short-description`, or `docs/short-description`.
- Commits: use concise imperative messages such as `Initialize Laravel foundation`.
- Pull requests: include scope, tests, security notes, and migration impact.
- Migration safety: never run destructive production commands; financial migrations require rollback and data-preservation review.
- Tests: add feature and unit coverage for new behavior and run `composer quality`.
- Coding standards: use Laravel conventions, Pint formatting, Larastan analysis, thin controllers, and testable services.
- Posted ledger rule: direct modification or deletion of posted ledger records is prohibited.
- Secrets: never commit `.env`, credentials, keys, dumps, or production configuration.

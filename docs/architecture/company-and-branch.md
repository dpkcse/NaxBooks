# Company and branch foundation
Companies use typed business and status enums. `DEFAULT` is provisioned as the sole default company and `HEAD_OFFICE` as its sole default branch. Codes are unique tenant-wide for companies and per company for branches. Archived records must never be promoted to defaults; default changes must be performed transactionally by a future dedicated action.

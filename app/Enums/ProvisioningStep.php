<?php
namespace App\Enums;
enum ProvisioningStep: string { case DatabaseCreated='database_created'; case Migrated='tenant_migrated'; case FoundationSeeded='foundation_seeded'; case DefaultCompany='default_company_created'; case DefaultBranch='default_branch_created'; case OwnerAccess='owner_company_access_created'; case Completed='completed'; }

<?php

return [
    'catalog' => [
        'dashboard.view' => ['Dashboard', 'View admin dashboard and operational summaries'],
        'listings.view' => ['Listings: view', 'View rooms, room options and rejection reasons'],
        'listings.manage' => ['Listings: manage', 'Create, edit, approve, reject or remove listings'],
        'people.view' => ['People: view', 'View users and property owners'],
        'people.manage' => ['People: manage', 'Create owners and block or unblock accounts'],
        'support.view' => ['Support: view', 'View complaints, enquiries, alerts and subscribers'],
        'support.manage' => ['Support: manage', 'Reply, update and remove support records'],
        'finance.view' => ['Finance: view', 'View payments, payouts, plans and offers'],
        'finance.manage' => ['Finance: manage', 'Process payouts and manage subscription plans'],
        'content.view' => ['Content: view', 'View blogs, offers, homepage and CMS pages'],
        'content.manage' => ['Content: manage', 'Create, edit or delete promotional and website content'],
        'reports.view' => ['Reports', 'View reports and search analytics'],
        'settings.manage' => ['Settings', 'Manage business, integration and maintenance settings'],
        'staff.manage' => ['Staff & roles', 'Create staff and manage role permissions'],
        'activity.view' => ['Activity logs', 'View administrative activity history'],
    ],
    'roles' => [
        'super_admin' => ['Super Admin', 'Full platform access', ['*']],
        'listing_moderator' => ['Listing Moderator', 'Reviews and moderates property listings', ['dashboard.view','listings.view','listings.manage','people.view','support.view']],
        'verification_executive' => ['Verification Executive', 'Handles owner and property verification workflows', ['dashboard.view','listings.view','listings.manage','people.view','people.manage','support.view']],
        'support_executive' => ['Support Executive', 'Resolves complaints and customer enquiries', ['dashboard.view','people.view','listings.view','support.view','support.manage']],
        'finance_manager' => ['Finance Manager', 'Manages payments, plans and finance reporting', ['dashboard.view','people.view','finance.view','finance.manage','reports.view']],
        'content_manager' => ['Content Manager', 'Manages CMS, blogs and promotional content', ['dashboard.view','content.view','content.manage','reports.view']],
    ],
];

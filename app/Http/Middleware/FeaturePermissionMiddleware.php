<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class FeaturePermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (!is_string($routeName)) {
            return $next($request);
        }

        if (method_exists($user, 'isBranchAdmin') && $user->isBranchAdmin() && str_starts_with($routeName, 'branch-admin.')) {
            return $next($request);
        }

        $permission = $this->permissionFromRouteName($routeName);

        if ($permission === null) {
            if ($this->isAlwaysAllowedSuperAdminRoute($routeName)) {
                return $next($request);
            }

            abort(403, 'You do not have permission to access this feature.');
        }

        if ($this->userHasPermission($user, $permission)) {
            return $next($request);
        }

        $feature = explode('.', $permission)[0];
        $managePermission = $feature . '.manage';

        if ($this->userHasPermission($user, $managePermission)) {
            return $next($request);
        }

        abort(403, 'You do not have permission to access this feature.');
    }

    protected function permissionFromRouteName(string $routeName): ?string
    {
        $parts = explode('.', $routeName);

        if (count($parts) < 2) {
            return null;
        }

        $feature = $parts[1];
        $action = end($parts);

        $permissionMap = [
            'banks' => 'banks',
            'branches' => 'branches',
            'branch-admins' => 'branch-admins',
            'admins' => 'admins',
            'permissions' => 'permissions',
            'loans' => 'loans',
            'loan-categories' => 'loan-categories',
            'service-categories' => 'service-categories',
            'service-types' => 'service-types',

            'payment-methods' => 'payment-methods',
            'package-orders' => 'package-orders',
            'lead-packages' => 'lead-packages',
            'badges' => 'badges',

            'customer-messages' => 'customer-messages',
            'customers' => 'customers',
            'applications' => 'applications',
            'new-applications' => 'applications',

            'ratings' => 'ratings',

            'profile' => 'profile',

            'logo-settings' => 'sitesettings',
            'about-settings' => 'sitesettings',
            'terms-conditions' => 'sitesettings',
            'homepage-carousels' => 'sitesettings',
            'image-advertisements' => 'sitesettings',
            'testimonials' => 'sitesettings',


        ];

        if (!array_key_exists($feature, $permissionMap)) {
            return null;
        }

        if (in_array($action, ['index', 'show', 'dashboard'], true)) {
            return $permissionMap[$feature] . '.view';
        }

        if (in_array($action, ['create', 'store'], true)) {
            return $permissionMap[$feature] . '.create';
        }

        if (in_array($action, ['edit', 'update'], true)) {
            return $permissionMap[$feature] . '.edit';
        }

        if (in_array($action, ['destroy', 'delete'], true)) {
            return $permissionMap[$feature] . '.delete';
        }

        return $permissionMap[$feature] . '.manage';
    }

    protected function isAlwaysAllowedSuperAdminRoute(string $routeName): bool
    {
        return in_array($routeName, [
            'super-admin.dashboard',
            'super-admin.profile.password.edit',
            'super-admin.profile.password',
        ], true);
    }

    protected function userHasPermission($user, string $permission): bool
    {
        $exists = Permission::query()
            ->where('name', $permission)
            ->where('guard_name', 'web')
            ->exists();

        if (!$exists) {
            return false;
        }

        return $user->hasPermissionTo($permission, 'web');
    }
}

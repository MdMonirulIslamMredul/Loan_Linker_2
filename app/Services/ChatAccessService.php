<?php

namespace App\Services;

use App\Models\User;
use App\Models\LeadAccess;

class ChatAccessService
{
    /**
     * Check if user1 is allowed to chat with user2.
     */
    public function canChat(User $user1, User $user2): bool
    {
        // Users cannot chat with themselves
        if ($user1->id === $user2->id) {
            return false;
        }

        // If either is super admin or bank admin, allow (assuming they are considered "Admin")
        if ($user1->isSuperAdmin() || $user1->isBankAdmin() || $user2->isSuperAdmin() || $user2->isBankAdmin()) {
            return true;
        }

        // Branch Admin and User (Customer) scenarios
        $isUser1BranchAdmin = $user1->isBranchAdmin();
        $isUser2BranchAdmin = $user2->isBranchAdmin();
        $isUser1Customer = $user1->isCustomer();
        $isUser2Customer = $user2->isCustomer();

        // Branch Admins cannot chat with Branch Admins
        if ($isUser1BranchAdmin && $isUser2BranchAdmin) {
            return false;
        }

        // Customers cannot chat with Customers
        if ($isUser1Customer && $isUser2Customer) {
            return false;
        }

        // If one is Branch Admin and the other is Customer, check LeadAccess
        if (($isUser1BranchAdmin && $isUser2Customer) || ($isUser1Customer && $isUser2BranchAdmin)) {
            $branchAdmin = $isUser1BranchAdmin ? $user1 : $user2;
            $customer = $isUser1Customer ? $user1 : $user2;

            return $this->hasLeadAccess($branchAdmin->id, $customer->id);
        }

        return false;
    }

    /**
     * Check if a branch admin has access to a customer's loan application.
     */
    private function hasLeadAccess($branchAdminId, $customerId): bool
    {
        return LeadAccess::where('officer_id', $branchAdminId)
            ->where(function ($query) use ($customerId) {
                $query->whereHas('application', function ($q) use ($customerId) {
                    $q->where('customer_id', $customerId);
                })->orWhereHas('newLoanApplication', function ($q) use ($customerId) {
                    $q->where('customer_id', $customerId);
                });
            })
            ->exists();
    }
}

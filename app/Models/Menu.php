<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'parent_id',
        'name',
        'url',
        'icon',
        'order'
    ];


    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_menu')
            ->withPivot('permissions')
            ->withTimestamps();
    }

    public function customUsers()
    {
        return $this->belongsToMany(User::class, 'custom_user_menu')
            ->withPivot('permissions')
            ->withTimestamps();
    }




    /** --------------- Fungsion untuk mendapatkan semua permissions menu --------------- */

    /**
     * Scope untuk mendapatkan hanya root menus (parent_id = null)
     */
    public function scopeRootMenus($query)
    {
        return $query->whereNull('parent_id')
            ->orderBy('order', 'asc');
    }

    /**
     * Scope untuk mendapatkan menus dengan parent tertentu
     */
    public function scopeWithParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId)
            ->orderBy('order', 'asc');
    }

    /**
     * Mendapatkan semua descendants (children, grandchildren, etc.)
     * Menggunakan recursive approach
     */
    public function getDescendantsAttribute(): Collection
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->descendants);
        }

        return $descendants;
    }

    /**
     * Mendapatkan semua ancestors (parent, grandparent, etc.)
     * Menggunakan recursive approach
     */
    public function getAncestorsAttribute(): Collection
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors->reverse(); // Urutkan dari top-level parent
    }

    /**
     * Mengecek apakah menu memiliki children
     */
    public function getHasChildrenAttribute(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Mendapatkan depth/level menu dalam hierarki
     */
    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    /**
     * Mendapatkan tree structure dari menu
     */
    public static function getTree(): Collection
    {
        $menus = self::with('children.children.children') // Sesuaikan depth sesuai kebutuhan
            ->rootMenus()
            ->get();

        return self::buildTree($menus);
    }

    /**
     * Helper function untuk membangun tree structure
     */
    private static function buildTree(Collection $menus): Collection
    {
        return $menus->map(function ($menu) {
            $menu->children = self::buildTree($menu->children);
            return $menu;
        });
    }

    /**
     * Mendapatkan breadcrumbs untuk menu tertentu
     */
    public function getBreadcrumbsAttribute(): array
    {
        $breadcrumbs = [];
        $ancestors = $this->ancestors;

        foreach ($ancestors as $ancestor) {
            $breadcrumbs[] = [
                'name' => $ancestor->name,
                'url' => $ancestor->url,
            ];
        }

        $breadcrumbs[] = [
            'name' => $this->name,
            'url' => $this->url,
        ];

        return $breadcrumbs;
    }

    /**
     * Mendapatkan menu yang accessible oleh user tertentu
     */
    public static function getAccessibleMenus(User $user): Collection
    {
        $allPermissions = $user->getAllPermissions();
        $allMenuIds = array_keys($allPermissions);

        return self::whereIn('id', $allMenuIds)
            ->with('children')
            ->rootMenus()
            ->get()
            ->filter(function ($menu) use ($allPermissions) {
                return !empty($allPermissions[$menu->id]);
            })
            ->map(function ($menu) use ($allPermissions) {
                // Filter children yang accessible juga
                $menu->children = $menu->children->filter(function ($child) use ($allPermissions) {
                    return !empty($allPermissions[$child->id]);
                });
                return $menu;
            });
    }

    /**
     * Generate HTML untuk navbar/sidebar
     */
    public static function generateNavbar(User $user = null): string
    {
        $user = $user ?? auth()->user();
        $menus = self::getAccessibleMenus($user);

        $html = '<ul class="navbar-nav">';

        foreach ($menus as $menu) {
            $html .= self::generateNavItem($menu, $user);
        }

        $html .= '</ul>';

        return $html;
    }

    /**
     * Helper untuk generate nav item
     */
    private static function generateNavItem(Menu $menu, User $user): string
    {
        $hasChildren = $menu->has_children;
        $activeClass = request()->is($menu->url) ? 'active' : '';

        $html = '<li class="nav-item' . ($hasChildren ? ' dropdown' : '') . '">';
        $html .= '<a href="' . ($hasChildren ? '#' : url($menu->url)) . '"';
        $html .= ' class="nav-link' . ($hasChildren ? ' dropdown-toggle' : '') . ' ' . $activeClass . '"';
        $html .= $hasChildren ? ' role="button" data-bs-toggle="dropdown" aria-expanded="false"' : '';
        $html .= '>';

        if ($menu->icon) {
            $html .= '<i class="' . $menu->icon . '"></i> ';
        }

        $html .= $menu->name . '</a>';

        if ($hasChildren) {
            $html .= '<ul class="dropdown-menu">';
            foreach ($menu->children as $child) {
                $html .= '<li><a class="dropdown-item" href="' . url($child->url) . '">';
                if ($child->icon) {
                    $html .= '<i class="' . $child->icon . '"></i> ';
                }
                $html .= $child->name . '</a></li>';
            }
            $html .= '</ul>';
        }

        $html .= '</li>';

        return $html;
    }

    /** --------------- ENDF OF Fungsion Area --------------- */
}

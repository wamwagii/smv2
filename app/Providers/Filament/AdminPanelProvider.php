<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\File;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Check if logo files exist
        $logoExists = File::exists(public_path('images/logo.svg'));
        $faviconExists = File::exists(public_path('images/favicon.ico'));
        
        $panel = $panel
            // Core configuration
            ->default()
            ->id('admin')
            ->path('admin')
            ->globalSearch(false)
            ->domain(config('app.domain', null))
            
            // Authentication & Authorization
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->authGuard('web')
            
            // Branding & UI
            ->brandName(config('app.name', 'School Management System'))
            ->darkMode(true)
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Zinc,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ]);
        
        // Add logo only if it exists
        if ($logoExists) {
            $panel->brandLogo(asset('images/logo.svg'))
                  ->brandLogoHeight('2rem')
                  ->darkModeBrandLogo(asset('images/logo-dark.svg')); // Optional
        } else {
            // Fallback to text logo
            $panel->renderHook(
                'panels::brand.logo',
                fn(): string => '<div style="font-weight: 600; font-size: 1.25rem; color: #F59E0B;">' . config('app.name') . '</div>'
            );
        }
        
        // Add favicon only if it exists
        if ($faviconExists) {
            $panel->favicon(asset('images/favicon.ico'));
        }
        
        // Continue with rest of configuration
        $panel
            // Layout & Navigation
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->collapsedSidebarWidth('4rem')
            ->navigationGroups([
                'School Management' => '🏫 School Management',
                'Fee Management' => '💰 Fee Management',
                'User Management' => '👥 User Management',
                'System' => '⚙️ System',
            ])
            
            // Resource Discovery
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            
            // Pages
            ->pages([Dashboard::class])
            ->widgets([])
            
            // Middleware
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            
            // Auth Middleware
            ->authMiddleware([Authenticate::class])
            
            // Additional Features
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->unsavedChangesAlerts()
            ->font('Inter')
            ->maxContentWidth('full');
        
        return $panel;
    }
}
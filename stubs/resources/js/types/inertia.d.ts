import { PageProps as InertiaPageProps } from '@inertiajs/core';

// Globally page props provided by `./app/Http/Middleware/HandleInertiaRequests.php`
interface AppPageProps {
  // This is where we can add our global page props
}

declare module '@inertiajs/core' {
  interface PageProps extends AppPageProps, InertiaPageProps {}
}
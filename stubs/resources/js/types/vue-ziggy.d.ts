// This makes the `route()` available globally within our <script> tags
import { route as routefn } from 'ziggy-js'
declare global {
  const route: typeof routefn;
}

// This makes `route()` available in the <template> to the type checker
declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    route: typeof routefn
  }
}
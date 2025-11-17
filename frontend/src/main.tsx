import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.tsx'
import { AccessibilityProvider } from './context/AccessibilityContext.tsx';

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <AccessibilityProvider>
    <App />
    </AccessibilityProvider>
  </StrictMode>,
)

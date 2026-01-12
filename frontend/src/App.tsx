
import './App.css'
import AppRouter from './Routes/AppRoute.tsx'
import { useAccessibility } from './context/AccessibilityContext.tsx';
import React from 'react'

function App() {
  const { fontSize, colorScheme, textToSpeechEnabled } = useAccessibility();

  React.useEffect(() => {
    document.body.className = `accessibility-scheme-${colorScheme}`;
    document.documentElement.style.fontSize = `${fontSize * 16}px`; 
  }, [colorScheme, fontSize])

  React.useEffect(() => {
    if (!textToSpeechEnabled) return;
    const content = document.body.innerText.replace(/\s+/g, ' ').trim();
    if (content.length > 0) {
      const utterance = new SpeechSynthesisUtterance(content);
      utterance.lang = 'id-ID'; 
      utterance.rate = 1.0;
      utterance.pitch = 1.0;
      window.speechSynthesis.cancel();
      window.speechSynthesis.speak(utterance);
    }
    return () => {
      window.speechSynthesis.cancel();
    };
  }, [textToSpeechEnabled]);
  return (
    <div className='min-h-screen px-10 py-10 md:px-10 md:py-10' style={{ fontSize: `${fontSize}rem`, backgroundColor: '#ededed' }}>
      <AppRouter />
    </div>
  )
}

export default App

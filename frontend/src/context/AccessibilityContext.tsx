import React, { createContext, useContext, useState, useEffect } from 'react';
import type { ReactNode } from 'react';

export type ColorScheme = 'default' | 'high-contrast' | 'dark' | 'grayscale' | 'text-to-speech';

interface AccessibilityContextType {
  fontSize: number;
  colorScheme: ColorScheme;
  language: 'id' | 'en';
  textToSpeechEnabled: boolean;

  increaseFontSize: () => void;
  decreaseFontSize: () => void;
  resetFontSize: () => void;
  setColorScheme: (scheme: ColorScheme) => void;
  toggleLanguage: () => void;
  toggleTextToSpeech: () => void;
  speak: (text: string) => void;
}

const AccessibilityContext = createContext<AccessibilityContextType | undefined>(undefined);

export const AccessibilityProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
  const [fontSize, setFontSize] = useState(1.0);
  const [colorScheme, setColorScheme] = useState<ColorScheme>('default');
  const [language, setLanguage] = useState<'id' | 'en'>('id');
  const [textToSpeechEnabled, setTextToSpeechEnabled] = useState(false);

  const toggleTextToSpeech = () => setTextToSpeechEnabled(prev => !prev);

  const increaseFontSize = () => setFontSize(prev => Math.min(prev + 0.2, 2.0));
  const decreaseFontSize = () => setFontSize(prev => Math.max(prev - 0.2, 0.8));
  const resetFontSize = () => {
    setFontSize(1.0);
    setColorScheme('default');
  };

  const toggleLanguage = () => setLanguage(prev => (prev === 'id' ? 'en' : 'id'));

  // 🎤 Fungsi TTS
  const speak = (text: string) => {
    if (!('speechSynthesis' in window)) return;
    if (!textToSpeechEnabled) return;

    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = language === 'id' ? 'id-ID' : 'en-US';
    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(utterance);
  };

  // 🧠 Event Listener global: hover & focus
  useEffect(() => {
    if (!textToSpeechEnabled) return;

    const handleHover = (e: Event) => {
      const target = e.target as HTMLElement;
      const text = target.innerText?.trim();
      if (text) speak(text);
    };

    document.addEventListener('mouseenter', handleHover, true);
    document.addEventListener('focus', handleHover, true);

    return () => {
      document.removeEventListener('mouseenter', handleHover, true);
      document.removeEventListener('focus', handleHover, true);
    };
  }, [textToSpeechEnabled, language]);

  useEffect(() => {
  const root = document.documentElement;

  switch (colorScheme) {
    case 'grayscale':
      root.style.filter = 'grayscale(100%)';
      break;

    case 'high-contrast':
      root.style.filter = 'contrast(150%)';
      break;

    case 'dark':
      root.style.filter = 'invert(1) hue-rotate(180deg)';
      break;

    default:
      root.style.filter = 'none';
      break;
  }
}, [colorScheme]);


  return (
    <AccessibilityContext.Provider
      value={{
        fontSize,
        colorScheme,
        language,
        textToSpeechEnabled,
        increaseFontSize,
        decreaseFontSize,
        resetFontSize,
        setColorScheme,
        toggleLanguage,
        toggleTextToSpeech,
        speak,
      }}
    >
      {children}
    </AccessibilityContext.Provider>
  );
};

// eslint-disable-next-line react-refresh/only-export-components
export const useAccessibility = () => {
  const context = useContext(AccessibilityContext);
  if (!context) {
    throw new Error('useAccessibility must be used within AccessibilityProvider');
  }
  return context;
};

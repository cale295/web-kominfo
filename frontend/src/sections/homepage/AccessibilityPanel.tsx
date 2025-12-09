import React, { useState, type JSX } from 'react';
import { useAccessibility } from '../../context/AccessibilityContext';
import { Button, Card, ListGroup, ToggleButton, ToggleButtonGroup } from 'react-bootstrap';
import {
  Accessibility as Wheelchair,
  Volume2,
  ZoomIn,
  ZoomOut,
  Contrast,
  Eye,
  Sun,
  Type,
  Link,
  AlignLeft,
  RotateCcw,
  Palette,
} from 'lucide-react';

interface AccessibilityOption {
  icon: JSX.Element;
  label: string;
  onClick?: () => void;
}

const AccessibilityPanel: React.FC = () => {
  const [showPanel, setShowPanel] = useState(false);
  const [language, setLanguage] = useState<'id' | 'en'>('id');
  
  React.useEffect(() => {
  const handleTogglePanel = () => setShowPanel(prev => !prev);
  window.addEventListener("toggleAccessibilityPanel", handleTogglePanel);
  return () => window.removeEventListener("toggleAccessibilityPanel", handleTogglePanel);
}, []);

  const {
  increaseFontSize,
  decreaseFontSize,
  resetFontSize,
  setColorScheme,
  toggleTextToSpeech,
  textToSpeechEnabled,
  speak,
} = useAccessibility();

  const options: AccessibilityOption[] = [
    {
      icon: <Volume2 size={18} />,
      label: textToSpeechEnabled
        ? language === 'id' ? 'Nonaktifkan Suara' : 'Disable Voice'
        : language === 'id' ? 'Aktifkan Suara' : 'Enable Voice',
      onClick: () => {
        toggleTextToSpeech?.();
        const statusText = textToSpeechEnabled
          ? (language === 'id' ? 'Mode suara dinonaktifkan' : 'Voice mode disabled')
          : (language === 'id' ? 'Mode suara diaktifkan' : 'Voice mode activated');
        speak?.(statusText);
      }
    },
    {
      icon: <ZoomIn size={18} />,
      label: language === 'id' ? 'Perbesar Teks' : 'Enlarge Text',
        onClick: increaseFontSize,
    },
    {
      icon: <ZoomOut size={18} />,
      label: language === 'id' ? 'Perkecil Teks' : 'Shrink Text',
        onClick: decreaseFontSize,
    },
    {
      icon: <Palette size={18} />,
      label: language === 'id' ? 'Skala Abu-Abu' : 'Grayscale',
    },
    {
      icon: <Contrast size={18} />,
      label: language === 'id' ? 'Kontras Tinggi' : 'High Contrast',
      onClick: () => setColorScheme('high-contrast'),
    },
    {
      icon: <Eye size={18} />,
      label: language === 'id' ? 'Latar Gelap' : 'Dark Background',
    },
    {
      icon: <Sun size={18} />,
      label: language === 'id' ? 'Latar Terang' : 'Light Background',
    },
    {
      icon: <Type size={18} />,
      label: language === 'id' ? 'Tulisan Dapat Dibaca' : 'Readable Font',
    },
    {
      icon: <Link size={18} />,
      label: language === 'id' ? 'Garis Bawahi Tautan' : 'Underline Links',
    },
    {
      icon: <AlignLeft size={18} />,
      label: language === 'id' ? 'Rata Tulisan' : 'Align Text',
    },
    {
      icon: <RotateCcw size={18} />,
      label: language === 'id' ? 'Atur Ulang' : 'Reset Settings',
        onClick: resetFontSize,

    },
  ];

  const togglePanel = () => setShowPanel(!showPanel);

  return (
    <>
      {/* Panel Sarana */}
      {showPanel && (
        <Card
          className="position-fixed top-0 start-0 m-3 p-3 shadow"
          style={{
            width: '280px',
            maxHeight: '90vh',
            overflowY: 'auto',
            zIndex: 9999,
            border: '1px solid #ccc',
            backgroundColor: '#fff',
          }}
        >
          <div className='d-flex justify-content-between align-items-center'>
            <div className="text-center fw-bold fs-5">Sarana</div>

            <Button variant="danger" onClick={togglePanel}>
              <Wheelchair size={18} />
            </Button>
          </div>

          {/* Toggle Bahasa */}
          <div className="d-flex justify-content-center my-3">
            <ToggleButtonGroup
              type="radio"
              name="language"
              value={language}
              onChange={(value) => setLanguage(value as 'id' | 'en')}
              className="btn-group-toggle"
            >
              <ToggleButton
                id="tbg-btn-id"
                value="id"
                variant="outline-secondary"
                size="sm"
              >
                Indonesia
              </ToggleButton>
              <ToggleButton
                id="tbg-btn-en"
                value="en"
                variant="outline-secondary"
                size="sm"
              >
                Inggris
              </ToggleButton>
            </ToggleButtonGroup>
          </div>

          {/* Daftar Opsi */}
          <ListGroup variant="flush">
            {options.map((option, index) => (
              <ListGroup.Item
                key={index}
                action
                className="d-flex align-items-center gap-2 py-2"
                onClick={() => {
                  console.log(`Clicked: ${option.label}`);
                  option.onClick?.(); 
                }}
              >
                <span className="d-flex align-items-center justify-content-center" style={{ width: 24 }}>
                  {option.icon}
                </span>
                <span>{option.label}</span>
              </ListGroup.Item>
            ))}
          </ListGroup>
        </Card>
      )}
    </>
  );
};

export default AccessibilityPanel;
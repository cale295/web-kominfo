
import './App.css'
import Navbar from './components/Navbar'
import HeroSection from './components/Hero'
import ServiceGrid from './components/Services'
import HubungiKami from './components/contact'

function App() {
  return (
    <div className='min-h-screen px-10 py-10'>
      <Navbar />
      <HeroSection />
      <ServiceGrid />
      <HubungiKami />
    </div>
  )
}

export default App

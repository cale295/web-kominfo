
import './App.css'
import Navbar from './components/Navbar'
import HeroSection from './components/Hero'
import ServiceGrid from './components/Services'
import TangerangNewsApp from './components/News'
import HubungiKami from './components/contact'
import Structure from './components/Structure'

function App() {
  return (
    <div className='min-h-screen px-10 py-10 md:px-10 md:py-10 '>
      <Navbar />
      <HeroSection />
      <ServiceGrid />
      <TangerangNewsApp />
      <Structure />
      <HubungiKami />
    </div>
  )
}

export default App

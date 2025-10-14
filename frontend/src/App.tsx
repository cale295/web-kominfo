
import './App.css'
import Navbar from './components/Navbar'
import HeroSection from './components/Hero'
import ServiceGrid from './components/Services'
import TangerangNewsApp from './components/News'

function App() {
  return (
    <div className='min-h-screen px-10 py-10'>
      <Navbar />
      <HeroSection />
      <ServiceGrid />
      <TangerangNewsApp />
    </div>
  )
}

export default App

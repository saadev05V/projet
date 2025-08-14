import './login.css'
import { Link } from 'react-router-dom'

export default function Login() {
  // Add this INSIDE the component function
  const handleSubmit = (e) => {
    e.preventDefault()
    // Add your authentication logic here
    // For now, we'll just redirect to dashboard
    window.location.href = '/dashboard'
  }

  return (
    <div className="container">
      <div className="card">
        <h1 className="title">Login</h1>
        {/* Update the form tag to use onSubmit */}
        <form className="form" onSubmit={handleSubmit}>
          <input
            type="email"
            placeholder="Email"
            className="input"
            required
          />
          <input
            type="password"
            placeholder="Password"
            className="input"
            required
          />
          <button type="submit" className="button">
            Sign In
          </button>
        </form>
        <p className="register-link">
          Don't have an account? <Link to="/register">Register here</Link>
        </p>
      </div>
    </div>
  )
}
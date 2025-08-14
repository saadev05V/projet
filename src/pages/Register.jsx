import './Register.css'
import { Link } from 'react-router-dom'

export default function Register() {
  return (
    <div className="container">
      <div className="card">
        <h1 className="title">Create Account</h1>
        <form className="form">
          <input
            type="text"
            placeholder="Full Name"
            className="input"
            required
          />
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
            Sign Up
          </button>
        </form>
        <p className="login-link">
          Already have an account? <Link to="/login">Login here</Link>
        </p>
      </div>
    </div>
  )
}
import { useState, useContext } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { AuthContext } from '../context/AuthContext';
import '../App.css';

export default function Login() {
  const [usernameOrEmail, setUsernameOrEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const { login } = useContext(AuthContext);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await login(usernameOrEmail, password);
      navigate('/dashboard');
    } catch (err) {
      setError('Invalid username/email or password');
    }
  };

  return (
    <div className="auth-container">
      <h2>Login</h2>
      {error && <p className="error-message">{error}</p>}
      
      <form onSubmit={handleSubmit}>
        <table className="auth-table">
          <tbody>
            <tr>
              <td>
                <input
                  type="text"
                  placeholder="Username or Email"
                  value={usernameOrEmail}
                  onChange={(e) => setUsernameOrEmail(e.target.value)}
                  required
                />
              </td>
            </tr>
            <tr>
              <td>
                <input
                  type="password"
                  placeholder="Password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                />
              </td>
            </tr>
            <tr>
              <td>
                <button type="submit" className="auth-button login-button">Login</button>
              </td>
            </tr>
          </tbody>
        </table>
      </form>

      <p className="auth-switch">
        Don't have an account? <Link to="/register" className="register-link">Register</Link>
      </p>
    </div>
  );
}
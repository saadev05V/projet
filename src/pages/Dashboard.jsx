import React, { useState } from 'react';
import "./Dashboard.css";

function Dashboard() {
  // Sample tasks data
  const [tasks, setTasks] = useState([
    { id: 1, title: 'Read project documentation', description: 'Review all project requirements', dueDate: '2023-06-15', status: 'in-progress' },
    { id: 2, title: 'Prepare presentation', description: 'Create slides for Friday meeting', dueDate: '2023-06-10', status: 'overdue' },
    { id: 3, title: 'Complete report', description: 'Finish the monthly progress report', dueDate: '2023-06-20', status: 'completed' },
  ]);

  const [newTask, setNewTask] = useState({
    title: '',
    description: '',
    dueDate: '',
    status: 'in-progress'
  });

  const [filter, setFilter] = useState('all');
  const [searchTerm, setSearchTerm] = useState('');

  // Filter tasks based on status and search term
  const filteredTasks = tasks.filter(task => {
    const matchesFilter = filter === 'all' || task.status === filter;
    const matchesSearch = task.title.toLowerCase().includes(searchTerm.toLowerCase()) || 
                         task.description.toLowerCase().includes(searchTerm.toLowerCase());
    return matchesFilter && matchesSearch;
  });

  // Add a new task
  const addTask = () => {
    if (newTask.title.trim() === '') return;
    
    const task = {
      id: tasks.length + 1,
      ...newTask
    };
    
    setTasks([...tasks, task]);
    setNewTask({
      title: '',
      description: '',
      dueDate: '',
      status: 'in-progress'
    });
  };

  // Delete a task
  const deleteTask = (id) => {
    setTasks(tasks.filter(task => task.id !== id));
  };


  const updateTaskStatus = (id, newStatus) => {
    setTasks(tasks.map(task => 
      task.id === id ? { ...task, status: newStatus } : task
    ));
  };

  return (
    <div className="dashboard">
      <header className="main-header">
        <h1 className="main-title big-title">
          Management<br />Tasks
        </h1>
      </header>

      <div className="controls">
        <div className="search">
          <input
            type="text"
            placeholder="Search tasks..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>

        <div className="filters">
          <button 
            className={filter === 'all' ? 'active' : ''}
            onClick={() => setFilter('all')}
          >
            All
          </button>
          <button 
            className={filter === 'in-progress' ? 'active' : ''}
            onClick={() => setFilter('in-progress')}
          >
            In Progress
          </button>
          <button 
            className={filter === 'completed' ? 'active' : ''}
            onClick={() => setFilter('completed')}
          >
            Completed
          </button>
          <button 
            className={filter === 'overdue' ? 'active' : ''}
            onClick={() => setFilter('overdue')}
          >
            Overdue
          </button>
        </div>
      </div>

      <div className="main-task-input dark-card">
        <textarea
          className="big-description-input"
          placeholder="Task description..."
          value={newTask.description}
          onChange={(e) => setNewTask({...newTask, description: e.target.value})}
          style={{height: '150px', width: '90%'}}
        />
        <div className="row-inputs">
          <div className="small-input-div">
            <input
              type="text"
              placeholder="Task title"
              value={newTask.title}
              onChange={(e) => setNewTask({...newTask, title: e.target.value})}
            />
          </div>
          <div className="small-input-div">
            <select
              value={newTask.status}
              onChange={(e) => setNewTask({...newTask, status: e.target.value})}
            >
              <option value="in-progress">In Progress</option>
              <option value="completed">Completed</option>
              <option value="overdue">Overdue</option>
            </select>
          </div>
        </div>
        <div className="date-save-row">
          <input
            type="date"
            value={newTask.dueDate}
            onChange={(e) => setNewTask({...newTask, dueDate: e.target.value})}
            className="date-input"
          />
          <button onClick={addTask} className="save-button dark-save">Save Task</button>
        </div>
      </div>

      <div className="task-list dark-task-list">
        <h2>Your Tasks</h2>
        {filteredTasks.length === 0 ? (
          <p className="no-tasks">No tasks found</p>
        ) : (
          filteredTasks.map(task => (
            <div key={task.id} className={`task-card dark-task-card ${task.status}`}>
              <div className="task-header">
                <h3>{task.title}</h3>
                <div className="task-actions">
                  <select
                    value={task.status}
                    onChange={(e) => updateTaskStatus(task.id, e.target.value)}
                  >
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="overdue">Overdue</option>
                  </select>
                  <button onClick={() => deleteTask(task.id)} className="delete-button dark-delete">Delete</button>
                </div>
              </div>
              <p className="task-description">{task.description}</p>
              <div className="task-footer">
                <span className="due-date">Due: {task.dueDate}</span>
                <span className={`status-badge ${task.status}`}>
                  {task.status === 'in-progress' && '🟡 In Progress'}
                  {task.status === 'completed' && '🟢 Completed'}
                  {task.status === 'overdue' && '🔴 Overdue'}
                </span>
              </div>
            </div>
          ))
        )}
      </div>
    </div>
  );
}

export default Dashboard;
"use client";

import React, { useState, useEffect } from 'react';

const Dashboard = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
  
    useEffect(() => {
      const fetchUsers = async () => {
        const query = `
          {
            users {
              id
              name
              email
            }
          }
        `;
  
        const response = await fetch('http://localhost:8000/graphql', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ query }),
        });
  
        const { data } = await response.json();
        console.log('aaaa', data);
        setUsers(data.users);
        setLoading(false);
      };
  
      fetchUsers();
    }, []);
  
    if (loading) {
      return <div>Loading...</div>;
    }
  
    return (
      <div>
        <h1>Users</h1>
        <ul>
          {users.map(user => (
            <li key={user.id}>
              {user.name} ({user.email})
            </li>
          ))}
        </ul>
      </div>
    );
  };

export default Dashboard;
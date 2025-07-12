import { defineStore } from 'pinia';
import axios from 'axios';
import { API_BASE_URL } from '../config';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    isAuthenticated: false,
  }),
  actions: {
    async login(credentials) {
      try {
        const response = await axios.post(`${API_BASE_URL}/login`, credentials);
        this.user = response.data.user;
        this.token = response.data.access_token;
        this.isAuthenticated = true;
        localStorage.setItem('user', JSON.stringify(this.user));
        localStorage.setItem('token', this.token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        return response.data;
      } catch (error) {
        this.logout();
        throw error;
      }
    },
    async logout() {
      try {
        if (this.token) {
          await axios.post(`${API_BASE_URL}/logout`, null, {
            headers: { 'Authorization': `Bearer ${this.token}` }
          });
        }
      } catch (error) {
        console.error('Logout error:', error);
      } finally {
        this.user = null;
        this.token = null;
        this.isAuthenticated = false;
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        delete axios.defaults.headers.common['Authorization'];
      }
    },
    initializeAuth() {
      const user = localStorage.getItem('user');
      const token = localStorage.getItem('token');
      if (user && token) {
        this.user = JSON.parse(user);
        this.token = token;
        this.isAuthenticated = true;
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      }
    },
  },
});

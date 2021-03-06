import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private loginCheckUrl = "http://127.0.0.1:8000/api/login_check";
  
  constructor(private http: HttpClient) { }

  loginUser(user){
    return this.http.post<any>(this.loginCheckUrl, user);
  }

  loggedIn(){
    return !!localStorage.getItem('token');
  }

  getToken(){
    return localStorage.getItem('token');
  }

}
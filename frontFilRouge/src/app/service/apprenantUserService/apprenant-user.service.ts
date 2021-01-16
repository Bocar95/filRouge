import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ApprenantUserService {

  defaultApprenantUrl = 'http://127.0.0.1:8000/api/apprenant';
  getApprenantUrl = 'http://127.0.0.1:8000/api/apprenants?isDeleted=false';

  constructor(private http: HttpClient) { }

  getApprenants() {
    return this.http.get(this.getApprenantUrl);
  }

  addApprenant(data){
    return this.http.post(this.defaultApprenantUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultApprenantUrl}/${id}`);
  }

  putApprenant(id:number, data){
    return this.http.put(`${this.defaultApprenantUrl}/${id}`, data);
  }

  deleteApprenant(id) {
    return this.http.delete(`${this.defaultApprenantUrl}/${id}`);
  }

}

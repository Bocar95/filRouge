import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class AdminUserService {

  defaultAdminUrl = 'http://127.0.0.1:8000/api/admin';
  getAdminUrl = 'http://127.0.0.1:8000/api/admins?isDeleted=false';

  constructor(private http: HttpClient) { }

  getAdmins() {
    return this.http.get(this.getAdminUrl);
  }

  addAdmin(data: any){
    return this.http.post(this.defaultAdminUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultAdminUrl}/${id}`);
  }

  putAdmin(id:number, data){
    return this.http.put(`${this.defaultAdminUrl}/${id}`, data);
  }

  deleteAdmin(id) {
    return this.http.delete(`${this.defaultAdminUrl}/${id}`);
  }

}

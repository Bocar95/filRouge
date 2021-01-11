import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminUserService {

  defaultAdminUrl = 'http://127.0.0.1:8000/api/admin';
  getAdminUrl = 'http://127.0.0.1:8000/api/admin?isDeleted=false';

  constructor(private http: HttpClient) { }

  getAdmins() {
    return this.http.get(this.getAdminUrl);
  }

  addAdmin(data){
    return this.http.post(this.defaultAdminUrl, data);
  }

  deleteAdmin(id) {
    return this.http.delete(`${this.defaultAdminUrl}/${id}`);
  }

}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class CmUserService {

  defaultCmUrl = 'http://127.0.0.1:8000/api/cm';
  getCmUrl = 'http://127.0.0.1:8000/api/cms?isDeleted=false';

  constructor(private http: HttpClient) { }

  getCms() {
    return this.http.get(this.getCmUrl);
  }

  addCm(data){
    return this.http.post(this.defaultCmUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultCmUrl}/${id}`);
  }

  putCm(id:number, data){
    return this.http.put(`${this.defaultCmUrl}/${id}`, data);
  }

  deleteCm(id) {
    return this.http.delete(`${this.defaultCmUrl}/${id}`);
  }

}

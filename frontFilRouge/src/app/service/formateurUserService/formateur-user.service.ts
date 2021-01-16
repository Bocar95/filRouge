import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class FormateurUserService {

  defaultFormateurUrl = 'http://127.0.0.1:8000/api/formateur';
  getFormateurUrl = 'http://127.0.0.1:8000/api/formateurs?isDeleted=false';

  constructor(private http: HttpClient) { }

  getFormateurs() {
    return this.http.get(this.getFormateurUrl);
  }

  addFormateur(data){
    return this.http.post(this.defaultFormateurUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultFormateurUrl}/${id}`);
  }

  putFormateur(id:number, data){
    return this.http.put(`${this.defaultFormateurUrl}/${id}`, data);
  }

  deleteFormateur(id) {
    return this.http.delete(`${this.defaultFormateurUrl}/${id}`);
  }

}

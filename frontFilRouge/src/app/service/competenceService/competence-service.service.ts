import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CompetenceServiceService {

  defaultCompetenceUrl = 'http://127.0.0.1:8000/api/admin/competences';
  getCompetenceUrl = 'http://127.0.0.1:8000/api/admin/competences?isDeleted=false';

  constructor(private http: HttpClient) { }

  getCompetences() {
    return this.http.get(this.getCompetenceUrl);
  }

  addCompetence(data: any){
    return this.http.post(this.defaultCompetenceUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultCompetenceUrl}/${id}`);
  }

  putCompetence(id:number, data){
    return this.http.put(`${this.defaultCompetenceUrl}/${id}`, data);
  }

  deleteCompetence(id) {
    return this.http.delete(`${this.defaultCompetenceUrl}/${id}`);
  }

  getGrpCompetenceOfCompById(id){
    return this.http.get(`${this.defaultCompetenceUrl}/${id}/groupecompetences`)
  }

}

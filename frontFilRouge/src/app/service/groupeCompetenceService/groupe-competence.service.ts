import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class GroupeCompetenceService {

  defaultGrpCompetenceUrl = 'http://127.0.0.1:8000/api/admin/grpCompetences';
  getGrpCompetenceUrl = 'http://127.0.0.1:8000/api/admin/grpCompetences?isDeleted=false';

  constructor(private http: HttpClient) { }

  getGrpCompetences() {
    return this.http.get(this.getGrpCompetenceUrl);
  }

  addGrpCompetence(data: any){
    return this.http.post(this.defaultGrpCompetenceUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultGrpCompetenceUrl}/${id}`);
  }

  putGrpCompetence(id:number, data){
    return this.http.put(`${this.defaultGrpCompetenceUrl}/${id}`, data);
  }

  deleteGrpCompetence(id) {
    return this.http.delete(`${this.defaultGrpCompetenceUrl}/${id}`);
  }

  getCompetencesOfGrpCompetence(id: number) {
    return this.http.get(`${this.defaultGrpCompetenceUrl}/${id}/competences`);
  }

}

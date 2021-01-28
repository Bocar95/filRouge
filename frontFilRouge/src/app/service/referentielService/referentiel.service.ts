import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ReferentielService {

  defaultReferentielUrl = 'http://127.0.0.1:8000/api/admin/referentiels';
  getReferentielUrl = 'http://127.0.0.1:8000/api/admin/referentiels?isDeleted=false';

  constructor(private http: HttpClient) { }

  getReferentiels() {
    return this.http.get(this.getReferentielUrl);
  }

  addReferentiel(data: any){
    return this.http.post(this.defaultReferentielUrl, data);
  }

  getById(id) {
    return this.http.get(`${this.defaultReferentielUrl}/${id}`);
  }

  putReferentiel(id:number, data){
    return this.http.put(`${this.defaultReferentielUrl}/${id}`, data);
  }

  getGrpCompOfRefById(id:number) {
    return this.http.get(`${this.defaultReferentielUrl}/${id}/grpecompetences`);
  }

}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class ProfilService {

  private getProfilUrl = 'http://127.0.0.1:8000/api/admin/profils?isDeleted=false';
  private defaultProfilUrl = 'http://127.0.0.1:8000/api/admin/profils';

  constructor(private http: HttpClient) { }

  getProfil() {
    return this.http.get(this.getProfilUrl);
  }

  addProfil(libelle): Observable<typeof libelle> {
    return this.http.post< typeof libelle>(this.getProfilUrl, libelle);
  }

  getProfilById(id) {
    return this.http.get(`${this.getProfilUrl}/${id}`);
  }

  putProfil(id, libelle) {
    return this.http.put(`${this.defaultProfilUrl}/${id}`, libelle);
  }

  deleteProfil(id) {
    return this.http.delete(`${this.defaultProfilUrl}/${id}`);
  }

}

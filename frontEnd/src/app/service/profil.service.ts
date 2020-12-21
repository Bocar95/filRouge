import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ProfilService {

  private profilUrl = 'http://127.0.0.1:8000/api/admin/profils';

  constructor(private http: HttpClient) { }

  getProfil() {
    return this.http.get(this.profilUrl);
  }

  addProfil(libelle) {
    return this.http.post(this.profilUrl, libelle);
  }

}

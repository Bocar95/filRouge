import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NiveauxService {

  defaultNiveauxUrl = 'http://127.0.0.1:8000/api/admin/niveaux';
  getNiveauxUrl = 'http://127.0.0.1:8000/api/admin/niveaux?isDeleted=false';

  constructor(private http: HttpClient) { }

  getNiveaux() {
    return this.http.get(this.getNiveauxUrl);
  }

}

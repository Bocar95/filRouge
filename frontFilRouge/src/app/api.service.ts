import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from  'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor(private httpClient: HttpClient) { }

  // PHP_API_SERVER = "http://127.0.0.1:8080";

  // readProfil(): Observable<Profil[]>{
  //   return this.httpClient.get<Profil[]>(`${this.PHP_API_SERVER}/`);
  // }

}

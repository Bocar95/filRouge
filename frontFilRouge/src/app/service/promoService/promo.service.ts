import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class PromoService {

  defaultPromoUrl = 'http://127.0.0.1:8000/api/admin/promo';
  getPromoUrl = 'http://127.0.0.1:8000/api/admin/promos?isDeleted=false';

  constructor(private http: HttpClient) { }

  addPromo(data: any){
    return this.http.post(this.defaultPromoUrl, data);
  }

}

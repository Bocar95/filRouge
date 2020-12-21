import { HttpEvent, HttpHandler, HttpInterceptor, HttpParams, HttpRequest, HTTP_INTERCEPTORS } from '@angular/common/http';
import { Injectable, Injector } from '@angular/core';
import { AuthService } from './auth.service';
import { Observable } from 'rxjs';
import { ProfilService } from './profil.service';

@Injectable({
  providedIn: 'root'
})
export class TokenInterceptorService implements HttpInterceptor {

  constructor(private injector: Injector) { }

  intercept(req, next) {
    let authService = this.injector.get(AuthService)
    let tokenizedReq = req.clone(
      {
        headers: req.headers.set('Authorization', 'bearer ' + authService.getToken())
      }
    )
    return next.handle(tokenizedReq)
  }

}

export const TokenInterceptorProvider = {
  provide: HTTP_INTERCEPTORS,
  useClass: TokenInterceptorService,
  multi: true
}

  // intercept(req:HttpRequest<any>, next:HttpHandler) : Observable<HttpEvent<any>> {
  //   let authService = this.injector.get(AuthService);
  //   const token = localStorage.getItem('token');

  //   if (token) {
  //     const tokenizedReq = req.clone(
  //       {
  //         params: new HttpParams().set('access_token', token)
  //       }
  //     );
  //     return next.handle(tokenizedReq);
  //   }else{
  //     return next.handle(req);
  //   }
  // }

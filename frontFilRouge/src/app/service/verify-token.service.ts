import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class VerifyTokenService {

  constructor() { }

  // verifyToken(req, res, next) {
  //   let jwt = req.headers.authorization

  //   let token = req.headers.authorization.split(' ')[1]

  //   let payload = jwt.verify(token, 'secretKey')

  //   if(!payload) {
  //     return res.status(401).send('Unauthorized request')    
  //   }

  //   req.userId = payload.subject
  //   next()
  // }

}

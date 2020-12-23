import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { HttpClientModule } from '@angular/common/http';
import { AuthService } from "./service/auth.service";
import { AcceuilComponent } from './acceuil/acceuil.component';
import { LoginComponent } from './login/login.component';
import { UserComponent } from './user/user.component';
import { AdminComponent } from './admin/admin.component';
import { FormateurComponent } from './formateur/formateur.component';
import { CmComponent } from './cm/cm.component';
import { ApprenantComponent } from './apprenant/apprenant.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ProfilService } from './service/profil.service';
import { AuthGuard } from './service/auth.guard';
import { TokenInterceptorProvider } from './service/token-interceptor.service';
import { VerifyTokenService } from './service/verify-token.service';
import { AngularMaterialModule } from '../material.module';
import { ProfilComponent } from './profil/profil.component';


@NgModule({
  declarations: [
    AppComponent,
    ConnexionComponent,
    LoginComponent,
    AcceuilComponent,
    ProfilComponent,
    UserComponent,
    AdminComponent,
    FormateurComponent,
    CmComponent,
    ApprenantComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    AppRoutingModule,
    HttpClientModule,
    BrowserAnimationsModule,
    AngularMaterialModule
  ],
  providers: [
    AuthService,
    AuthGuard,
    ProfilService,
    VerifyTokenService,
    TokenInterceptorProvider
  ],
  bootstrap: [AppComponent]
})

export class AppModule { CUSTOM_ELEMENTS_SCHEMA }
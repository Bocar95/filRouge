import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { FormsModule, ReactiveFormsModule} from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { HttpClientModule } from '@angular/common/http';
import { AuthService } from "./service/authService/auth.service";
import { AcceuilComponent } from './acceuil/acceuil.component';
import { UserComponent } from './user/user.component';
import { AdminComponent } from './acceuil/admin/admin.component';
import { FormateurComponent } from './acceuil/formateur/formateur.component';
import { CmComponent } from './acceuil/cm/cm.component';
import { ApprenantComponent } from './acceuil/apprenant/apprenant.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ProfilService } from './service/profilService/profil.service';
import { AuthGuard } from './service/authGuardService/auth.guard';
import { TokenInterceptorProvider } from './service/tokenInterceptorService/token-interceptor.service';
import { VerifyTokenService } from './service/verify-token.service';
import { AngularMaterialModule } from '../material.module';
import { ProfilComponent } from './acceuil/admin/profil/profil.component';
import { AcceuilHeaderComponent } from './acceuil/acceuil-header/acceuil-header.component';
import { AcceuilBodyComponent } from './acceuil/acceuil-body/acceuil-body.component';
import { AcceuilFooterComponent } from './acceuil/acceuil-footer/acceuil-footer.component';
import { AddProfilComponent, DialogOverviewExampleDialog } from './acceuil/admin/profil/add-profil/add-profil.component';
import { ListProfilsComponent } from './acceuil/admin/profil/list-profils/list-profils.component';
import { AdminHeaderComponent } from './acceuil/admin/admin-header/admin-header.component';
import { AdminBodyComponent } from './acceuil/admin/admin-body/admin-body.component';
import { DefaultListProfilsComponent } from './acceuil/admin/profil/default-list-profils/default-list-profils.component';
import { DetailsProfilComponent } from './acceuil/admin/profil/details-profil/details-profil.component';
import { MatTableModule } from '@angular/material/table';
import { MatDialogModule } from '@angular/material/dialog';
import { MatPaginatorModule } from '@angular/material/paginator';
import { NgbModule, NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { AdminUserComponent } from './acceuil/admin/admin-user/admin-user.component';
import { AddAdminComponent } from './acceuil/admin/admin-user/add-admin/add-admin.component';
import { ListAdminComponent } from './acceuil/admin/admin-user/list-admin/list-admin.component';
import { FormulaireAddUserComponent } from './acceuil/admin/formulaire-add-user/formulaire-add-user.component';



@NgModule({
  declarations: [
    AppComponent,
    ConnexionComponent,
    AcceuilComponent,
    ProfilComponent,
    UserComponent,
    AdminComponent,
    FormateurComponent,
    CmComponent,
    ApprenantComponent,
    AcceuilHeaderComponent,
    AcceuilBodyComponent,
    AcceuilFooterComponent,
    AddProfilComponent,
    ListProfilsComponent,
    AdminHeaderComponent,
    AdminBodyComponent,
    DefaultListProfilsComponent,
    DetailsProfilComponent,
    DialogOverviewExampleDialog,
    AdminUserComponent,
    AddAdminComponent,
    ListAdminComponent,
    FormulaireAddUserComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    AppRoutingModule,
    HttpClientModule,
    BrowserAnimationsModule,
    AngularMaterialModule,
    MatTableModule,
    MatDialogModule,
    MatPaginatorModule,
    NgbModule,
    NgbPaginationModule,
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
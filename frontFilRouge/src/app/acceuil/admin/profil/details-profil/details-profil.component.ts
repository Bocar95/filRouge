import { Component, OnInit } from '@angular/core';
import { ProfilService } from 'src/app/service/profilService/profil.service';
import { Router, RouterStateSnapshot } from '@angular/router';
import { element } from 'protractor';

@Component({
  selector: 'app-details-profil',
  templateUrl: './details-profil.component.html',
  styleUrls: ['./details-profil.component.css'],
  styles: [`
      :host ::ng-deep .p-cell-editing {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      }
  `]
})
export class DetailsProfilComponent implements OnInit {

  users = [];
  profils;
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  toDetails: number;
  i = 0;
  j = 0;
  elseResponse = 'Il N\'Y A PAS ENCORE D\'UTILISATEUR AVEC CE POUR.';
  first = 0;
  rows = 5;

  constructor(
    private profilService: ProfilService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.toDetails = this.getIdOnUrl();
    this.profilService.getUsersOfProfil(this.toDetails).subscribe(
      (res: any) => {
        this.users = res;
        console.log(this.users);
      }
    );
    this.profilService.getProfilById(this.toDetails).subscribe(
      (data: any) => {
        this.profils = data;
        console.log(data);
      }
    );
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    this.id = this.url.split('/');
    return this.id[4];
  }

  reloadCurrentRoute() {
    let currentUrl = this.router.url;
    return this.router.navigateByUrl('/', {skipLocationChange: true}).then(() => {
        this.router.navigate([currentUrl]);
    });
  }

  // for(var i=0, len = this.elementFind.length; i < len ; i++  ){
  //   this.users = this.elementFind[i];
  // }

}

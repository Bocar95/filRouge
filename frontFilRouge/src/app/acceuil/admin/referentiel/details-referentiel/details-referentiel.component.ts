import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ReferentielService } from 'src/app/service/referentielService/referentiel.service';

@Component({
  selector: 'app-details-referentiel',
  templateUrl: './details-referentiel.component.html',
  styleUrls: ['./details-referentiel.component.css']
})
export class DetailsReferentielComponent implements OnInit {

  element = [];
  grpCompetences = [];
  referentiels;
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  toDetails: number;
  i = 0;
  j = 0;
  elseResponse = 'Il n\'y a pas encore de groupe de competences dédier à ce référentiel.';

  constructor(
    private referentielService: ReferentielService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.toDetails = this.getIdOnUrl();
    this.referentielService.getGrpCompOfRefById(this.toDetails).subscribe(
      (res: any) => {
        this.element = res;
        this.grpCompetences = this.element["groupeCompetences"];
        console.log(res);
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

}

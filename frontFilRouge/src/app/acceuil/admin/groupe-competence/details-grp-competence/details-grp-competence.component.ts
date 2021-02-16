import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { GroupeCompetenceService } from 'src/app/service/groupeCompetenceService/groupe-competence.service';

@Component({
  selector: 'app-details-grp-competence',
  templateUrl: './details-grp-competence.component.html',
  styleUrls: ['./details-grp-competence.component.css']
})
export class DetailsGrpCompetenceComponent implements OnInit {

  element = [];
  competences = [];
  snapshot: RouterStateSnapshot;
  url: string;
  id = [];
  toDetails: number;
  i = 0;
  j = 0;
  elseResponse = 'Il n\'y a pas encore de competences dédier à ce groupe de compétence.';

  constructor(
    private grpCompetenceService: GroupeCompetenceService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.toDetails = this.getIdOnUrl();
    this.grpCompetenceService.getCompetencesOfGrpCompetenceById(this.toDetails).subscribe(
      (res: any) => {
        this.element = res;
        this.competences = this.element["competences"];
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

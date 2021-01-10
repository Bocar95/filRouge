import { Component, OnInit } from '@angular/core';
import { Params, Router } from '@angular/router';
import { ProfilService } from 'src/app/service/profilService/profil.service';
import { HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-default-list-profils',
  templateUrl: './default-list-profils.component.html',
  styleUrls: ['./default-list-profils.component.css']
})
export class DefaultListProfilsComponent implements OnInit {

  profils: any = [];
  btnText = 'Plus de détail';

  constructor(private profilService: ProfilService,
              private router: Router
              ) { }

  ngOnInit(): void {
    this.profilService.getProfil().subscribe(
      (data: any) => {
        this.profils = data;
        console.log(data)
      }
    );
  }

  onClickDetailBtn() {
    // return this.route.HttpParams.subscribe(
    //   params =>{
        
    //     var test = this.profilService.getProfilById(+params.get('id'))
    //   }
    // );
  }

}

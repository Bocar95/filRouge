import { Component, OnInit } from '@angular/core';
import { AcceuilHeaderComponent } from '../acceuil-header/acceuil-header.component';

@Component({
  selector: 'app-acceuil-body',
  templateUrl: './acceuil-body.component.html',
  styleUrls: ['./acceuil-body.component.css']
})
export class AcceuilBodyComponent implements OnInit {

  acceuilHeader = new AcceuilHeaderComponent;

  constructor() { }

  ngOnInit(): void {
  }

  Admin() {
    return this.acceuilHeader.Admin();
  }

}

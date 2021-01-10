import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsProfilComponent } from './details-profil.component';

describe('DetailsProfilComponent', () => {
  let component: DetailsProfilComponent;
  let fixture: ComponentFixture<DetailsProfilComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DetailsProfilComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailsProfilComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsReferentielComponent } from './details-referentiel.component';

describe('DetailsReferentielComponent', () => {
  let component: DetailsReferentielComponent;
  let fixture: ComponentFixture<DetailsReferentielComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DetailsReferentielComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailsReferentielComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

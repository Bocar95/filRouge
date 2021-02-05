import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutPromoComponent } from './formulaire-put-promo.component';

describe('FormulairePutPromoComponent', () => {
  let component: FormulairePutPromoComponent;
  let fixture: ComponentFixture<FormulairePutPromoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutPromoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutPromoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

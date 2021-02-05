import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailsPromoComponent } from './details-promo.component';

describe('DetailsPromoComponent', () => {
  let component: DetailsPromoComponent;
  let fixture: ComponentFixture<DetailsPromoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DetailsPromoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailsPromoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

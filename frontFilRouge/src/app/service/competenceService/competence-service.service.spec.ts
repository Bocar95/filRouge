import { TestBed } from '@angular/core/testing';

import { CompetenceServiceService } from './competence-service.service';

describe('CompetenceServiceService', () => {
  let service: CompetenceServiceService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CompetenceServiceService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
